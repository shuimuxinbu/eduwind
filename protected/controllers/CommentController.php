<?php

class CommentController extends AbleController
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
		//	'rights',
		);
	}

	public function allowedActions()
	{
		return 'index, view';
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
		'actions'=>array('create','fileUpload','imageUpload','imageList','toggleVote'),
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

	public function actions()
	{
		return array(
		//'fileUpload'=>array('ext.redactor.actions.FileUpload','uploadCreate'=>true),
		'toggleVote'=>array(
							'class'=>'application.components.actions.ToggleVoteAction',
				)
		);
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
		$dataProvider=new CActiveDataProvider('Comment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Comment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Comment']))
		$model->attributes=$_GET['Comment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * 添加vote
	 * @param unknown_type $id
	 */
	/*	public function actionToggleVote($id,$value){

	$comment = $this->loadModel($id);
	$comment->toggleVote(Yii::app()->user->id,$value);
	$this->renderPartial('/vote/result',array('score'=>$comment->voteUpNum,'voteUpers'=>$comment->getVoteUperDataProvider()->getData()));

	}
	*/
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Comment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Comment::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Comment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Comment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
