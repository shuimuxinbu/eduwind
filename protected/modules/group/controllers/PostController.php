<?php

/**
 * 小组帖子Controller
 */
class PostController extends Controller
{
	/**
	 * @var string layout文件 
	 */
	public $layout='//layouts/column1';
	
    
	/**
     * 过滤器方法
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}
    
	
    /**
     * 返回外部动作列表
     * @return array
     */
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
     * 当前控制器的访问规则
     *
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', 
				'actions'=>array('counter','view'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('create','update','setTop','addComment','toggleVote','toggleFollow'),
				'users'=>array('@'),
			),
            // @todo 管理员和小组管理员可以执行的方法
            array(
                'allow',
                'actions'   =>  array(),
                'roles'     =>  array('admin'),
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	
	/**
	 * 删除帖子处理
	 * @param integer $id 小组ID
	 * @param integer $postId 帖子ID
	 */
	public function actionDelete($id,$postId){
		$post = Post::model()->findByPk($postId);
		$group = $this->loadGroup($id);
		if(!$post->postableEntityId==$group->entityId){
			Yii::app()->user->setFlash('error',Yii::t('app','参数错误'));
			$this->redirect(array('post','id'=>$postId));
			Yii::app()->end();
		}
		$member = $group->findMember(array('userId'=>Yii::app()->user->id));
		if(Yii::app()->user->checkAccess('deletePost',array('post'=>$post)) ||
		($member &&$member->inRoles(array('superAdmin','admin')))){
			$group->deletePost($post);
            if($post->deleted == 1) {
				Yii::app()->user->setFlash('success',Yii::t('app','删除成功！'));
				$this->redirect(array('index/view','id'=>$id));
			} else {
				Yii::app()->user->setFlash('error',Yii::t('app','删除失败！'));
				$this->redirect(array('view','id'=>$postId));
			}
		}else{
			Yii::app()->user->setFlash('error',Yii::t('app','错误,权限不足!'));
			$this->redirect(array('view','id'=>$id));
		}
	}
	

    /**
     * 更新帖子页面和处理
     * @param integer $id 帖子ID
     */
	public function actionUpdate($id){
		$model=$this->loadModel($id);
		if(Yii::app()->user->checkAccess('updatePost',array('post'=>$model))){

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
	 * 置顶post
	 * @param integer $id 小组ID
	 * @param integer $postId 帖子ID
     * @param unknow_type $value
	 */
	public function actionSetTop($id,$postId,$value){
		$post = Post::model()->findByPk($postId);
		$group = $this->loadGroup($id);
		if(!$post->postableEntityId==$group->entityId){
			Yii::app()->user->setFlash('error',Yii::t('app','参数错误'));
			$this->redirect(array('post','id'=>$postId));
			Yii::app()->end();
		}
		$member = $group->findMember(array('userId'=>Yii::app()->user->id));
		if($member &&$member->inRoles(array('superAdmin','admin'))){
			$post->isTop = $value>0 ? 1 : 0;
			if($post->save()){
				Yii::app()->user->setFlash('success',Yii::t('app','操作成功！'));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','操作失败！'));
			}
		}else{
			Yii::app()->user->setFlash('error',Yii::t('app','错误,权限不足!'));
		}
		$this->redirect(array('view','id'=>$post->id));
	}


	/**
	 * 删除post处理
	 * @param integer $id 小组ID
	 * @param integer $commentId 
	 */
	public function actionDeleteComment($id,$commentId){
		$group = $this->loadGroup($id);
		$comment = Comment::model()->find(array(
            'join'=>'inner join ew_post p on p.entityId=t.commentableEntityId inner join ew_group g on p.postableEntityId=g.entityId',
            'condition'=>'t.id=:commentId',
            'params'=>array('commentId'=>$commentId)
        ));

		$post = Post::model()->findByAttributes(array('entityId'=>$comment->commentableEntityId));
		if(!$post->postableEntityId==$group->entityId){
			Yii::app()->user->setFlash('error',Yii::t('app','参数错误'));
			$this->redirect(array('post','id'=>$postId));
			Yii::app()->end();
		}
		$member = $group->findMember(array('userId'=>Yii::app()->user->id));
		if(Yii::app()->user->checkAccess('Admin') ||
		($member &&$member->inRoles(array('superAdmin','admin')))){
            $post->deleteComment($comment);
            if($comment->deleted == 1) {
				Yii::app()->user->setFlash('success',Yii::t('app','删除成功！'));
				$this->redirect(array('view','id'=>$post->id));
            } else {
				Yii::app()->user->setFlash('error',Yii::t('app','删除失败！'));
				$this->redirect(array('view','id'=>$post->id));
            }
		}else{
			Yii::app()->user->setFlash('error',Yii::t('app','错误,权限不足!'));
			$this->redirect(array('view','id'=>$post->id));
		}
	}
	

	/**
	 * 发表帖子页面和处理
	 * @param integer $groupId 帖子ID
	 */
	public function actionCreate($groupId){
		$group = $this->loadGroup($groupId);
		$post = new Post;

		if(isset($_POST['Post'])){
			$post->attributes = $_POST['Post'];
			if($group->addPost($post)){
				Yii::app()->user->setFlash('success',Yii::t('app','发布成功！'));
				$this->redirect(array('view','id'=>$post->getPrimaryKey()));
			}
		}
		$this->render('create',array('post'=>$post,'group'=>$group));
	}


	/**
	 * 查看一个帖子
	 * @param integer $id 帖子ID
	 */
	public function actionView($id){
        $post = $this->loadModel($id);
		//$group = $post->postableEntity->getModel();
		$group = $post->group;
		$member = GroupMember::model()->findByAttributes(array('groupId'=>$id,'userId'=>Yii::app()->user->id));
		if(!$member) $member = new GroupMember();
		$followDataProvider = $post->getFollowDataProvider();
		$this->render('view',array(
            'post'=>$post,
            'group'=>$group,
            'member'=>$member,
            'followDataProvider'=>$followDataProvider
        ));
	}
    

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Post::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	
    /**
     * 返回一个Group model
     * @param integer $id 小组ID
     */
	public function loadGroup($id)
	{
		$model=Group::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
		

	/**
	 * Performs the AJAX validation.
	 * @param object $model CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='group-course-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
