<?php

class IndexController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin/nonav_column1';
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{

		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
//		'rights',
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
		'actions'=>array('index','setStatus','delete','toggleIsTop','setting'),
		'roles'=>array('admin'),
		),
		array('deny',  // deny all users
		'users'=>array('*'),
		),
		);
	}
	
	public function actionSetting(){
		$model = new CourseForm();
		$model->getSetting();
		
		if(isset($_POST['CourseForm'])){
			$model->attributes = $_POST['CourseForm'];
			if($model->saveSetting()){
				Yii::app()->user->setFlash('success','保存成功！');
			}else{
				Yii::app()->user->setFlash('error','保存失败！');
			}
		}
		$this->render('setting',array('model'=>$model));
	}
		
	public function actionSetStatus($id,$status){
		$course = Course::model()->findByPk($id);
		$oldState = $course->status;
		$course->status = $status;
		$result = $course->save();
		if($result && ($oldState=="apply" && $status==Course::STATUS_OK)){
			$notice = new Notice;
			$notice->type = 'course_publish';
			$notice->setData(array('courseId'=>$id));
			$notice->userId = $course->userId;
			$notice->save();
		}
		if($result){
			Yii::app()->user->setFlash('success','操作成功');	
		}
		$this->redirect(array('index'));
	}
	
	/**
	 * 发布/取消发布 课时
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function actionToggleIsTop($id){
		$course = Course::model()->findByPk($id);
		$course->isTop = $course->isTop>0 ? 0 :1;
		if($course->save()){
			if($course->isTop>0)
				Yii::app()->user->setFlash('success','置顶成功');
			else 	
				Yii::app()->user->setFlash('success','取消置顶成功');
		};
		$this->redirect(array('index','id'=>$id));
		
	}
	
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if($this->loadModel($id)->delete()){
			Yii::app()->user->setFlash('success','删除成功！');
		}else{
			Yii::app()->user->setFlash('success','删除失败！');
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}


	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new Course('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Course']))
		$model->attributes=$_GET['Course'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Course the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Course::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Course $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
