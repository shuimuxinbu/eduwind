<?php

class MessageController extends Controller
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
				'actions'=>array('create','update'),
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
	public function actionView($userId)
	{
		$dataProvider = new CActiveDataProvider('Message',array('criteria'=>array(
																			'condition'=>'(fromUserId='.intval($userId).' or toUserId='.intval($userId).') and fromUserId+toUserId='.($userId+Yii::app()->user->id),
																			'order'=>'addTime desc')
												));
		Message::model()->updateAll(array('isChecked'=>1),'toUserId=:toUserId and fromUserId=:fromUserId and isChecked=0',array(':toUserId'=>Yii::app()->user->id,':fromUserId'=>$userId));
		$user = UserInfo::model()->findByPk($userId);
		$this->render('view',array(
			'dataProvider'=>$dataProvider,
			'user'=>$user,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($toUserId=0)
	{
		$model=new Message;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Message']))
		{
			$model->attributes=$_POST['Message'];
			$model->addTime = time();
			$model->fromUserId = Yii::app()->user->id;
			
			//if($model->save()){
			echo $model->save() ? true : false;
			Yii::app()->end();
			//}
//				$this->redirect(array('view','id'=>$model->messageid));
		}
 		Yii::app()->clientScript->scriptMap['*.js'] = false;
		
		$toUser = UserInfo::model()->findByPk($toUserId);
		$this->renderPartial('create',array(
			'model'=>$model,
			'toUser'=>$toUser
		),false,true);
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

		if(isset($_POST['Message']))
		{
			$model->attributes=$_POST['Message'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->messageid));
		}

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
		$user = UserInfo::model()->findByPk(Yii::app()->user->id);
		$messages = Message::model()->findAll(array('select'=>'max(id) as id',
													'condition'=>'toUserId='.Yii::app()->user->id." or fromUserId=".Yii::app()->user->id,
													'group'=>'toUserId+fromUserId',
													'order'=>'max(addTime) desc'
											));
		
		foreach($messages as $key=>$item){
			$messages[$key] = Message::model()->findByPk($item->id);
		}
		$dataProvider=new CArrayDataProvider($messages,array('keyField'=>'id','pagination'=>array('pageSize'=>50)));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'user'=>$user,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Message('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Message']))
			$model->attributes=$_GET['Message'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Message the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Message::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Message $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='message-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
