<?php

class UserController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin/nonav_column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{

		return array(
		//	'accessControl', // perform access control for CRUD operations
		//			'postOnly + delete', // we only allow deletion via POST request
					'rights',

		);

	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*	public function accessRules()
	 {
		return array(
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
		'actions'=>array('index','view','create','update','admin','delete','toggleFrozened','toggleAdmin'),
		'users'=>array('@'),
		),
		array('deny',  // deny all users
		'users'=>array('*'),
		),
		);
		}*/

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * 设置、取消冻结状态
	 * @param unknown_type $id
	 */
	public function actionToggleFrozened($id){
		$user = $this->loadModel($id);
		$user->status= $user->status=="frozened" ? "ok" : "frozened";
		if($user->save()){
			Yii::app()->user->setFlash('success','设置成功！');
		}else{
			Yii::app()->user->setFlash('error','设置失败！');
		}
		$this->redirect(array('admin'));
	}

	/**
	 * 设置、取消管理员身份
	 * @param unknown_type $id
	 */
	public function actionToggleAdmin($id){
		$user = $this->loadModel($id);
		$user->isAdmin= $user->isAdmin>0 ? 0 : 1;
		if($user->save()){
			Yii::app()->user->setFlash('success','设置成功！');
		}else{
			Yii::app()->user->setFlash('error','设置失败！');
		}
		$this->redirect(array('admin'));
	}

	/**
	 * 设置、取消用户的实验室成员身份
	 * @param unknown $id
	 */
	public function actionTogglePeople($id) {
		$user = $this->loadModel($id);
		$people = $user->people;
		if ($people) {
			if($people->delete())
			Yii::app()->user->setFlash('success','已将用户移除实验室成员！');
		}
		else {
			$people = new People;
			$people->name = $user->name;
			$people->userId = $user->id;
			$people->email = $user->email;
			if($people->save())
			Yii::app()->user->setFlash('success','已将用户设为实验室成员！');
		}
		$this->redirect(array('admin'));
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new UserInfo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UserInfo']))
		{
			$model->attributes=$_POST['UserInfo'];
			if($model->save())
			$this->redirect(array('view','id'=>$model->userId));
		}

		$this->render('create',array(
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

		if(isset($_POST['UserInfo']))
		{
			$model->attributes=$_POST['UserInfo'];
			$model->arrRoles = $_POST['UserInfo']['arrRoles'];
			$operator = UserInfo::model()->findByPk(Yii::app()->user->id);
			if($operator->inRoles(array('admin')) && !$operator->inRoles(array('superAdmin'))){
				$arrRoles = $model->arrRoles;
				foreach($arrRoles as $key=>$item){
					if($item=="admin"|| $item=="superAdmin") unset($arrRoles[$key]);
				}
				$model->arrRoles = $arrRoles;
			}
			if($model->save()){
				Yii::app()->user->setFlash('success','保存成功');
				$this->redirect(array('admin','id'=>$model->id));
			}
		}
		//		if(!$model) $model = new UserInfo;
		$this->render('update',array(
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
		$dataProvider=new CActiveDataProvider('UserInfo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new UserInfo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserInfo']))
		$model->attributes=$_GET['UserInfo'];

		$onlineNum = Yii::app()->getSession()->getOnlineNum();

		$this->render('admin',array(
			'model'=>$model,
			'onlineNum'=>$onlineNum,
		));
	}

	public function actionSetRoles($id){
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UserInfo']))
		{
			$model->roles = $_POST['UserInfo']['roles'];
			if($model->save()){
				Yii::app()->user->setFlash('success','设置成功！');
			}else{
				Yii::app()->user->setFlash('error','设置失败！');
			}
		}

		$this->render('set_roles',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return UserInfo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=UserInfo::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param UserInfo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-info-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
