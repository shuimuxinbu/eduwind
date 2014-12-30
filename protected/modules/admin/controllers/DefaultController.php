<?php

class DefaultController extends RController
{
	public function filters()
	{
		return array(
		//	'accessControl', // perform access control for CRUD operations
		//	'postOnly + delete', // we only allow deletion via POST request
		'rights',
		);
	}
	
	public function actionIndex()
	{
/*		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(array("course/admin"));
		}
		// display the login form
		$this->render('login',array('model'=>$model));*/
		
		//检查更新包情况
		UpgradeService::getService()->checkUpgradeServer();
		
		$this->redirect(array('/admin/setting/site'));
	}
}