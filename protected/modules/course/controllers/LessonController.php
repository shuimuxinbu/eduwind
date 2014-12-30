<?php

class LessonController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
		array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','counter','videoFile'),
				'users'=>array('*'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','editByCourse','privateNote',
								'comment','playlist','toggleFinishLearn',
								'addComment','saveNote','link'),
				'users'=>array('@'),
		),
		array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
		),
		array('deny',  // deny all users
				'users'=>array('*'),
		),
		);
	}

	public function actions()
	{
		/*		return array(
		 'upload'=>array(
		 'class'=>'xupload.actions.XUploadAction',
		 'path' =>Yii::app() -> getBasePath() . "/../uploads",
		 'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
		 ),
		 );*/
		return array(
			'saveNote'=>array('class'=>'application.components.actions.noteable.SaveNoteAction'),
		);
	}
	public function actionLink(){
		//	$lessons = Lesson::model()->findAllByAttributes(array('mediaType'=>'link'));
		$criteria = new CDbCriteria();
		$criteria->condition = "mediaType='' and mediaUri!=''";
		$lessons = Lesson::model()->findAll($criteria);
		foreach($lessons as $lesson){
			$link = new MediaLink();
			$link->url = $lesson->mediaUri;
			$link->title = $lesson->title;
			if($link->save()){
				$lesson->mediaType = "link";
				$lesson->mediaId = $link->getPrimaryKey();
				$lesson->save();
			}
		}
	}

	public function actionView($id){
		$lesson = $this->loadModel($id);
		$course = $lesson->course;
		// modified by wzh
		/*
		$courseMember = CourseMember::model()->findByAttributes(array('courseId'=>$course->id,'userId'=>Yii::app()->user->id));
		if(!$courseMember && !$lesson->isFree){
		Yii::app()->user->setFlash('error','请您先选修课程！！！');
		}
		if($courseMember && $courseMember->inRoles(array('member','student'))){
		if(time()>$courseMember->endTime){
		Yii::app()->user->setFlash('error','您的课时学习到期了,请重新购买！！！');
		}
		}
		*/
		//	var_dump($lesson);
		$lessonDataProvider = $course->getLessonDataProvider();
		//$member = $lesson->course->findMember(array('userId'=>Yii::app()->user->id));
		$member = $course->findMember(array('userId'=>Yii::app()->user->id));
		if(!$member && !$lesson->isFree){
			Yii::app()->user->setFlash('error',Yii::t('app','请先选修课程！'));
			$this->redirect(array('/course/index/view','id'=>$lesson->courseId));
		}else if($member && !$member->isValid()){
			Yii::app()->user->setFlash('error',Yii::t('app','您的课时学习到期了,请重新购买！'));
			$this->redirect(array('/course/index/view','id'=>$lesson->courseId));
		}
		$postDataProvider=new CActiveDataProvider('CoursePost',array('criteria'=>array('condition'=>'lessonId=:lessonId','params'=>array(':lessonId'=>$lesson->id),'order'=>"isTop desc,upTime desc")));
		$learn = LessonLearn::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'lessonId'=>$lesson->id));
		if(!$learn){
			$learn = new LessonLearn;
			$learn->init($lesson->id, Yii::app()->user->id);
			$learn->start();
		}
		$myNote = $lesson->findNote(array('userId'=>Yii::app()->user->id));
		global $sysSettings;
		if(isset($sysSettings['course']['chatEnabled']) && $sysSettings['course']['chatEnabled']){
			$this->render("view_chat",array('lesson'=>$lesson,
										'course'=>$lesson->course,
										'lessonDataProvider'=>$lessonDataProvider,
										'myNote'=>($myNote ? $myNote : new Note),
										'member'=>$member,

			//'commentDataProvider'=>$lesson->getCommentDataProvider(),
			//		'commentDataProvider'=>new CActiveDataProvider('CourseComment',array('criteria'=>array('condition'=>'lessonId='.$lesson->id,'order'=>'id desc'))),
										'postDataProvider'=>$postDataProvider,

			));
		}else if($lesson->mediaType=="quiz"){
			$this->redirect(array('quiz/take','id'=>$lesson->mediaId));
		}else{
			$viewFile = "view";
			$this->render("view",array('lesson'=>$lesson,
										'course'=>$lesson->course,
										'lessonDataProvider'=>$lessonDataProvider,
										'myNote'=>($myNote ? $myNote : new Note),
										'member'=>$member,
										'postDataProvider'=>$postDataProvider,
			));
		}
	}

	/**
	 * 添加评论
	 * @param unknown_type $id
	 */
	public function actionAddComment($id){
		$comment = new Comment;
		$lesson = $this->loadModel($id);
		if(isset($_POST['Comment'])){
			$comment->attributes = $_POST['Comment'];
			if($lesson->addComment($comment)){
				$commentDataProvider = $lesson->getCommentDataProvider(array('criteria'=>array('order'=>'addTime desc')));
				//	var_dump($commentDataProvider->getData());
				$this->renderPartial('_comments',array('commentDataProvider'=>$commentDataProvider,'lesson'=>$lesson));
			}
		}
	}

	public function actionToggleFinishLearn($id){
		//$learn = new LessonLearn($id, Yii::app()->user->id);
		$learn = LessonLearn::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'lessonId'=>$id));
		if($learn){
			if($learn->status==LessonLearn::STATUS_FINISH){
				$learn->notFinish();
			}
			else{
				$learn->finish();
			}
		}
/*        $currentLesson  =   $this->loadModel($id);
        $nextLesson     =   Lesson::model()->find('courseId=' . $currentLesson->courseId . ' and ' . 'weight=' . ($currentLesson->weight+1));
        $this->renderPartial('_toggleFinishLearn', array('nextLesson'=>$nextLesson));
		$learn->status==LessonLearn::STATUS_FINISH ? true : false;
*/
		echo $learn->status==LessonLearn::STATUS_FINISH ? "恭喜，请继续努力" : "请继续努力";

}

	public function actionVideoFile($id){
		$lesson = $this->loadModel($id);
		$course = $lesson->course;
		$member = $course->findMember(array('userId'=>Yii::app()->user->id));
		if(!$member && !$lesson->isFree)
		throw new CHttpException(404,Yii::t('app','请先选修课程！'));
		if(in_array('mod_xsendfile', apache_get_modules())){
			Yii::app()->getRequest()->xSendFile($lesson->file->path,array('forceDownload'=>false,'mimeType'=>$lesson->file->mime));
		}else{
			if(substr(PHP_VERSION,0,3) <=5.2)
				ini_set('memory_limit', '-1');
			Yii::app()->getRequest()->sendFile("1.".CFileHelper::getExtension($lesson->file->path), @file_get_contents($lesson->file->path),$lesson->file->mime);
		}
	}


	/**
	 * 计数器
	 * @param unknown_type $course
	 */
	public function actionCounter($id){
		$lesson = $this->loadModel($id);
		$lesson->viewNum+=1;
		$lesson->save();
		$course = $lesson->course;
		$course->viewNum+=1;
		$course->save();
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Lesson the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Lesson::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Lesson $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lesson-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
