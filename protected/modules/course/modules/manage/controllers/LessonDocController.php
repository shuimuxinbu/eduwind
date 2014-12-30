<?php

class LessonDocController extends CaController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = "/layouts/nonav_column1";
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('create','update','delete'),
				'expression'=>array($this,'allowOnlyAdmin'),
						),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}



	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($lessonId)
	{
		$model=new LessonDoc;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LessonDoc']))
		{
			$model->attributes=$_POST['LessonDoc'];
			$model->lessonId = $lessonId;
			if($model->save()){
				Yii::app()->user->setFlash('success',Yii::t('app','上传成功，可继续上传'));
			}
		}
		
		$this->render('create_fancy',array(
			'model'=>$model,
			'lessonId'=>$lessonId,
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

		if(isset($_POST['LessonDoc']))
		{
			$model->attributes=$_POST['LessonDoc'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update_fancy',array(
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
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=LessonDoc::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lesson-doc-form')
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
		if(isset($_GET['id'])) {
			$lessonDoc = $this->loadModel($_GET['id']);
			$lesson = $lessonDoc->lesson;
		}else if(isset($_GET['lessonId'])){
			$lesson = Lesson::model()->findByPk($_GET['lessonId']);
		}
		if(isset($lesson) && $lesson->course){
			$member = $lesson->course->findMember(array('userId'=>Yii::app()->user->id));
			if($member && $member->inRoles(array('admin','superAdmin'))) return true;
		}
		return false;
	}
}
