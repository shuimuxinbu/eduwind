<?php

class CourseModule extends WModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'course.models.*',
			'course.components.*',
		));
		 $this->defaultController="index";
		 $this->setModules(array('manage'));
		 $this->setModules(array('admin'));
		 $this->setModules(array('pay'=>array('public_key'=>'sk_test_FkZIzRBJ6te1CMJoiSs77Z6m',
									'private_key'=>'pk_test_CmanxXPM4UBrFzm7LEJO8DO')));
	}

	public function beforeControllerAction($controller, $action)
	{
		if($controller->id=="me"){
			$controller->activeMenu="me";
		}
		else{
			$controller->activeMenu="course";
		}
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	public function getDisplayName(){
		return Yii::t('app',"课程");
	}
	
	public function getVersion(){
		return "1.0";
	}
	
}
