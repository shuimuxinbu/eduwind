<?php

class PostController extends AbleController
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
		//	'postOnly + delete', // we only allow deletion via POST request
		//'rights',
		);
	}
	public function allowedActions()
	{
		return 'index, view';
	}

	public function actions() {
		return array(
		'toggleFollow'=>array(
					'class'=>'application.components.actions.ToggleFollowAction',),
		'addComment'=>array(
					'class'=>'application.components.actions.commentable.AddCommentAction',
		),
		'toggleVote'=>array(
					'class'=>'application.components.actions.ToggleVoteAction',
		));
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
				'actions'=>array('index','view','counter'),
		//'actions'=>array('view'),
				'users'=>array('*'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','toggleFollow','addComment','comment','toggleVote'),
				'users'=>array('@'),
		),
		array('deny',  // deny all users
				'users'=>array('*'),
		),
		);
	}





	public function actionUpdate($id){
		$model=$this->loadModel($id);
		if(Yii::app()->user->checkAccess('updatePost',array('post'=>$model))){
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Post']))
			{
				$model->attributes=$_POST['Post'];
				if($model->save()){
					Yii::app()->user->setFlash('success',Yii::t('app','更新成功!'));
					$this->redirect(array('view','id'=>$model->id));
				}
			}

			$this->render('update',array(
			'model'=>$model,
			));
		}
	}

	/**
	 * 添加vote
	 * @param unknown_type $id
	 */
	/*	public function actionToggleVote($id,$value){

	$post = $this->loadModel($id);
	$post->toggleVote(Yii::app()->user->id,$value);
	$this->renderPartial('/vote/result',array('score'=>$post->voteUpNum,'voteUpers'=>$post->getVoteUperDataProvider()->getData()));

	}
	*/
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
	 * modified by lsy 20130808
	 */
	public function actionIndex($groupid)
	{
		$dataProvider=new CActiveDataProvider('Post', array(
				'criteria'=>array(
						'condition'=>'groupid='.$groupid,
						'order'=>'addTime DESC',
		),
				'pagination'=>array(
						'pageSize'=>10,
		),
		));
		$group = Group::model()->findByPk($groupid);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'group'=>$group,
		));
	}
	/*
	 * modified by lsy 20130808
	 */
	/**
	 * 被要求显示一条comment
	 * @param unknown_type $id
	 */
	public function actionComment($id){
		$comment = Comment::model()->findByPk($id);
		$post = $comment->commentableEntity->getModel();
		$this->redirect(array('group/post','id'=>$post->id));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Post the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Post::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
