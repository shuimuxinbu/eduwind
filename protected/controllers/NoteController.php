<?php

class NoteController extends AbleController
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','editByCourse','privateNote','comment','youkuPlayList'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		//		$lesson = $this->loadModel($id);
		$lesson = Lesson::model()->with('course','comments.user')->findByPk($id);
		if(!Yii::app()->user->isGuest && !CourseLearn::model()->hasLearn(Yii::app()->user->id,$lesson->courseId)){
			$lesson->course->addLearn(array('userId'=>Yii::app()->user->id,'status'=>'learning'));
		}
		$privateNote = PrivateLessonNote::model()->findByAttributes(array('lessonid'=>$id,'userId'=>Yii::app()->user->id));
		$commentDataProvider = new CArrayDataProvider($lesson->comments,array('keyField'=>'commentId',
																		    'pagination'=>array(
																			        'pageSize'=>20,
		)));
		$this->render('view',array(
			'lesson'=> $lesson,
			'commentDataProvider'=>$commentDataProvider,
			'privateNote'=>$privateNote
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($courseId=0)
	{
		$model=new Lesson;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Lesson']))
		{
			$model->attributes=$_POST['Lesson'];
			if($model->save()){
				//				$this->redirect(array('view','id'=>$model->lessonid));
				echo true;
				Yii::app()->end();
			}
		}

		$model->course = Course::model()->findByPk($courseId);
		$this->renderPartial('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Lesson']))
		{
			$model->attributes=$_POST['Lesson'];
			if($model->save())
			$this->redirect(array('view','id'=>$model->lessonid));
		}

		$this->renderPartial('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Lesson');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Lesson('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Lesson']))
		$model->attributes=$_GET['Lesson'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	


	/**
	 * 批量编辑课程下的全部课时
	 * @param unknown_type $courseId
	 */
	public function actionEditByCourse($courseId=0){
		Yii::import('ext.multimodelform.MultiModelForm');
		$course = Course::model()->findByPk($courseId);
		$lesson = new Lesson;
		$validatedLessons = array();

		if(isset($_POST['Lesson']))
		{
			//			$model->attributes=$_POST['Group'];

			//the value for the foreign key 'groupid'
			$masterValues = array ('courseId'=>$course->courseId);

			//Save the master model after saving valid members
			if( MultiModelForm::save($lesson,$validatedLessons,$deleteLessons,$masterValues))
			$this->redirect(array('course/view','id'=>$course->courseId));
		}

		$this->render('editByCourse',array(
			'course'=>$course,
			'lesson'=>$lesson,
			'validatedLessons'=>$validatedLessons
		));
	}
	/**
	 * 一次性导入优酷视频
	 * Enter description here ...
	 * @param unknown_type $courseId
	 */
	public function actionYoukuPlayList($courseId=0){
		if(isset($_POST['url'])){
			$url = $_POST['url'];
			//			$output = Yii::app()->curl->get($_POST['url']);
			//			$partern = "";
			Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');
			// Create DOM from URL or file
			$simpleHTML = new SimpleHTMLDOM;
			$html = $simpleHTML->file_get_html($url);
			$urlDict= array('playlist'=>array('pattern'=>"/\/playlist_show\/id_/i",'selector'=>'#list1_1 .items  li.v_title a'),
							'episode'=>array('pattern'=>"/\/show_page\/id_/i",'selector'=>'#episode li.ititle_w a'));

			foreach($urlDict as $key=>$item){
				if(preg_match($item['pattern'], $url)){
					$type = $key;
					$selector = $item['selector'];
					break;
				}
			}
				
			// Find all images
			foreach($html->find($selector) as $elem){
				$lesson = new Lesson;
				$lesson->courseId = $courseId;
				$lesson->title = $elem->getAttribute("title") ? $elem->getAttribute("title") : $elem->innertext;
				$pattern = "/id_(.*)\/?\.html/i";
				preg_match($pattern,$elem->href,$matches);
				if($matches[1]){
					//		http://player.youku.com/player.php/sid/XNTk5MTQ3OTQ0/v.swf
					$lesson->url = "http://player.youku.com/player.php/sid/$matches[1]/v.swf";
				}else{
					continue;
				}
				$lesson->addTime = time();
				$lesson->save();
			}
			$this->redirect(array('lesson/editByCourse','courseId'=>$courseId));
			Yii::app()->end();
		}
		$course = Course::model()->findByPk($courseId);
		$this->renderPartial("youkuPlayList",array('course'=>$course),false,true);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionPrivateNote($lessonid)
	{
		$privateNote=PrivateLessonNote::model()->findByAttributes(array('lessonid'=>$lessonid,'userId'=>Yii::app()->user->id));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if($privateNote)
		{
			//			$$privateNote->attributes=$_POST['PrivateLessonNote'];
			$privateNote->upTime = time();
			$privateNote->content = $_POST['note'];
			if($privateNote->save())
			echo true;
			//$this->redirect(array('view','id'=>$$privateNote->noteid));
		}else{
			$privateNote = new PrivateLessonNote;
			$privateNote->content = $_POST['note'];
			$privateNote->lessonid = $lessonid;
			$privateNote->userId = Yii::app()->user->id;
			$privateNote->addTime = time();
			$privateNote->upTime = time();
			if($privateNote->save())
			echo true;
		}

		//		$this->render('create',array(
		//			'model'=>$model,
		//		));
	}

	public function actionComment(){
		$comment = new LessonComment;
		if(isset($_POST['LessonComment'])){
			$comment->attributes = $_POST['LessonComment'];
			$comment->userId=Yii::app()->user->id;
			$comment->addTime = time();
			if($comment->save()){
				$comment = LessonComment::model()->findByPk($comment->getPrimaryKey());
				if($comment->referid){
					$notice = new Notice;
					$notice->type = 'lesson_recomment';
					$notice->setData(array('commentId'=>$comment->commentId));
					$notice->userId = $comment->refer->userId;
					$result = $notice->save();
				}
				$commentDataProvider = new CArrayDataProvider($comment->lesson->comments,array('keyField'=>'commentId',
																		    'pagination'=>array(
																			        'pageSize'=>20,
				)));
				$feed = new Feed;
				$feed->type = 'lesson_comment';
				$feed->setData(array('commentId'=>$comment->getPrimaryKey()));
				$feed->save();
				$feed->dispatch(array('user'=>array('userId'=>$comment->userId),'course'=>array('courseId'=>$comment->lesson->courseId)));
				
				$this->renderPartial('_comment',array('commentDataProvider'=>$commentDataProvider));
			}
		}
		//		$this->redirect(array('view','id'=>$comment->lessonid));
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
