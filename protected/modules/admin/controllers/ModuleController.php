<?php

class ModuleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
//			'right'
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
				'actions'=>array('index','toggleNav','toggleActive','list'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionToggleNav($id){
		$model = new ModuleForm();
		$model->getSetting();
		if(!is_array($model->navModules)) $model->navModules = array();
		if(($key=array_search($id, $model->navModules))!==false){
			 unset($model->navModules[$key]);
		}else{
			$model->navModules[] = $id;
		}
		$model->navModules = array_unique($model->navModules);
		if($model->saveSetting()){
			Yii::app()->user->setFlash('success','操作成功！');
		}else{
			Yii::app()->user->setFlash('success','操作失败！');
		}
		$this->redirect(array('list'));
	}

	public function actionToggleActive($id){
		$model = new ModuleForm();
		$model->getSetting();
		if(!is_array($model->activeModules)) $model->activeModules = array();
		if(($key=array_search($id, $model->activeModules))!==false){
			 unset($model->activeModules[$key]);
		}else{
			$model->activeModules[] = $id;
		}
		$model->activeModules = array_unique($model->activeModules);
		if($model->saveSetting()){
			Yii::app()->user->setFlash('success','操作成功！');
		}else{
			Yii::app()->user->setFlash('success','操作失败！');
		}
		$this->redirect(array('list'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		$this->render('index');
	}

	public function actionList(){
		$modules =  $this->getInstalledModules();
		$setting = new ModuleForm();
		$setting->getSetting();

		$this->layout = "//layouts/admin/nonav_column1";
		$this->render('list',array('modules'=>$modules,'setting'=>$setting));
	}
	/**
	 * 获取所有安装的wmodule
	 * Enter description here ...
	 */
	public function getInstalledModules(){
		$moduleRoot = dirname(__FILE__)."/../../";
		$modules=array();
		$dir = opendir($moduleRoot);
		while(($file=readdir($dir))!==false){
			if($file!="." && $file!=".." && is_dir("$moduleRoot/$file")){
				$moduleClassName = ucfirst($file)."Module";
				$moduleFile = "$moduleRoot/$file/".$moduleClassName.".php";
				if(is_file($moduleFile)){
//					Yii::import($moduleFile);
					require_once $moduleFile;
					$module = new $moduleClassName($file,null);
					if($module instanceof WModule) $modules[] = $module;
				}
			}
		}
		return $modules;
	}

}
