<?php

class ChapterController extends CaController
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
		//			'postOnly + delete', // we only allow deletion via POST request
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
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','update','togglePublished','publishAll','hideAll','view','create',
								'createMany','delete','upload','link','setMedia','addQuiz','addLecture','order'),
				'users'=>array("@"),
		),
		array('allow',
			  'actions'=>array('convert'),
			  'users'=>array('*')),
		array('deny',  // deny all users
				'users'=>array('*'),
		),
		);
	}


	/**
	 * 添加课程
	 * @param unknown_type $id
	 */
	public function actionCreate($courseId){
		$course = Course::model()->findByPk($courseId);
		$model = new Chapter;
		if(isset($_POST['Chapter'])){
			$model->attributes = $_POST['Chapter'];
			$model->userId = Yii::app()->user->id;
			if($model->save()){
				Yii::app()->user->setFlash('success',Yii::t('app','添加成功！'));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','添加失败！'));
			}
			$this->redirect(array('lesson/index','courseId'=>$model->courseId));
		}
		$model->courseId = $courseId;
		$this->layout = "/layouts/nonav_column1";
		$this->renderPartial('create_fancy',array('course'=>$course,'model'=>$model),false,true);
	}
	/**
	 * 修改课时信息
	 * @param unknown_type $id
	 */
	public function actionUpdate($id){
		$model =$this->loadModel($id);
		$course = $model->course;
		if(isset($_POST['Chapter'])){
			$model->attributes = $_POST['Chapter'];
			if($model->save()){
				Yii::app()->user->setFlash('success',Yii::t('app','保存成功！'));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','抱歉！保存失败！'));
			}
			$this->redirect(array('index','courseId'=>$model->courseId));
		}
		$this->layout = "/layouts/nonav_column1";
		$this->renderPartial('update_fancy',array('course'=>$course,'model'=>$model),false,true);

	}
	
	public function actionDelete($id){
		$lesson = $this->loadModel($id);
		if($lesson->delete())
		Yii::app()->user->setFlash('success',Yii::t('app','删除成功！'));
		else
		Yii::app()->user->setFlash('error',Yii::t('app','删除失败！'));
		$this->redirect(array('index/index','courseId'=>$lesson->courseId));
	}

	public function actionView($id){
		$this->redirect(array('//lesson/view','id'=>$id));
	}

	public function actionConvert(){
		$files = UploadFile::model()->findAllByAttributes(array('storage'=>'cloud'));
		$cloud = CloudService::getInstance();
		foreach($files as $file){
			if(!$file->convertKey){
				echo $file->path;
				echo $cloud->convert($file->path);
				echo "\n";
			}
		}
	}

	public function actionPublishAll($courseId){
		$course = $this->loadCourse($courseId);
		$result = true;
		$lessons = Lesson::model()->findAll(array('condition'=>'published=0'));
		foreach($lessons as $lesson){
			if(!$lesson->saveAttributes(array('published'=>1)))
			$result = false;
		}
		if($result)
		Yii::app()->user->setFlash('success',Yii::t('app','操作成功！'));
		else
		Yii::app()->user->setFlash('error',Yii::t('app','操作失败！'));
		$this->redirect(array('index','courseId'=>$course->id));
	}

	public function loadModel($id)
	{
		$model=Chapter::model()->findByPk($id);
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


	/**
	 * 检查权限
	 */
	public function allowOnlyAdmin(){
		if(Yii::app()->user->checkAccess('admin')) return true;
		if(isset($_GET['id']) ) {
			$lesson = $this->loadModel(intval($_GET['id']));
			$course = $lesson->course;
		}elseif(isset($_GET['lessonId']) ) {
			$lesson = $this->loadModel(intval($_GET['lessonId']));
			$course = $lesson->course;
		}else if(isset($_GET['courseId'])){
			$course = $this->loadCourse(intval($_GET['courseId']));
		}
		$member = $course->findMember(array('userId'=>Yii::app()->user->id));
		if($member && $member->inRoles(array('admin','superAdmin'))) return true;
		return false;
	}
}
