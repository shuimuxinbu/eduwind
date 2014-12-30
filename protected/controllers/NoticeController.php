<?php

class NoticeController extends Controller
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
		array('allow','actions'=>array('sendCloudMail','test'),'users'=>array('*')),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'users'=>array('@'),
		),
		array('deny'  // deny all users
		),
		);
	}

	/**
	 * 显示评论类型系统消息
	 */
	public function actionCommentAdded(){
		$user = UserInfo::model()->findByPk(Yii::app()->user->id);
		//		Notice::model()->updateAll(array('isChecked'=>1),'userId=:userId and isChecked=0 and type=:type',array('userId'=>Yii::app()->user->id,'type'=>':type'));
		$dataProvider = new CActiveDataProvider('Notice',array('criteria'=>array('condition'=>'userId=:userId','params'=>array('userId'=>Yii::app()->user->id),'order'=>'addTime desc')));
		$uncheckedNums = Notice::model()->countTypeUncheckeds(Yii::app()->user->id);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'user'=>$user,
			'uncheckedNums'=>$uncheckedNums,
		));

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		//		$dataProvider=new CActiveDataProvider('Notice',array('userId'=>Yii::app()->user->id));
		$user = UserInfo::model()->findByPk(Yii::app()->user->id);
		Notice::model()->updateAll(array('isChecked'=>1),'userId=:userId and isChecked=0',array('userId'=>Yii::app()->user->id));
		$dataProvider = new CArrayDataProvider($user->notices,array('keyField'=>'id'));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'user'=>$user
		));
		//		$this->redirect(array('commentAdded'));
	}

	public function actionHovercard(){
		$user = UserInfo::model()->findByPk(Yii::app()->user->id);
		if(count($user->noticesUnisChecked)>0){
			$dataProvider = new CArrayDataProvider($user->noticesUnisChecked,array('keyField'=>'id'));
			Notice::model()->updateAll(array('isChecked'=>1),'userId=:userId and isChecked=0',array('userId'=>Yii::app()->user->id));
		}else{
			$dataProvider = new CActiveDataProvider('Notice',  array(
									'criteria'=>array(
									'condition'=>'userId='.Yii::app()->user->id,
							        'order'=>'addTime DESC',
			),
							    	'pagination'=>array('pageSize'=>5)));
		}
		Yii::app()->clientScript->scriptMap['*.js'] = false;
		$this->renderPartial('hovercard',array(
			'dataProvider'=>$dataProvider,
		),false,true);
		//		$this->renderPartial('hovercard',null,false,true );
	}



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Notice the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Notice::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Notice $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='notice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
