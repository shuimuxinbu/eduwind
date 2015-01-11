<?php

class PostController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='/layouts/nonav_column1';
	public $layout='//layouts/column1';

    /**
     * @var TabMenu 视图文件名
     */
    public $viewMenuName = '/index/_view_menu_nopay';

    /**
     * @var 头部 视图文件名
     */
    public $viewHeaderName = '/index/_view_header_nopay';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function actions() {
		return array(
		'toggleFollow'=>array(
					'class'=>'application.components.actions.ToggleFollowAction',),
		//		'addComment'=>array(
		//					'class'=>'application.components.actions.commentable.AddCommentAction',
		//		),
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
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('counter','view'),
				'users'=>array('*'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','delete','update','setTop','addComment', 'index',
								'toggleVote','toggleFollow','ajaxCreate','createInLesson','createInCourse'),
				'users'=>array('@'),
		),
		array('deny',  // deny all users
				'users'=>array('*'),
		),
		);
	}


	/**
	 * 删除post
	 * @param unknown_type $id
	 * @param unknown_type $postId
	 */
	public function actionDelete($id,$postId){
		$post = Post::model()->findByPk($postId);
		$course = $this->loadCourse($id);
		if(!$post->postableEntityId==$course->entityId){
			Yii::app()->user->setFlash('error',Yii::t('app','参数错误'));
			$this->redirect(array('post','id'=>$postId));
			Yii::app()->end();
		}
		$member = $course->findMember(array('userId'=>Yii::app()->user->id));
		if(Yii::app()->user->checkAccess('deletePost',array('post'=>$post)) ||
		($member &&$member->inRoles(array('superAdmin','admin')))){
			if($course->deletePost($post)){
				Yii::app()->user->setFlash('success',Yii::t('app','删除成功！'));
				$this->redirect(array('view','id'=>$id));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','删除失败！'));
				$this->redirect(array('post','id'=>$postId));
			}
		}else{
			Yii::app()->user->setFlash('error',Yii::t('app','错误,权限不足!'));
			$this->redirect(array('view','id'=>$id));
		}
	}

    /**
     * 课程评价页
     */
    public function actionIndex($courseId)
    {
        $model = $this->loadCourse($courseId);

        // 教师数据提供者
        $teacherDataProvider = new CActiveDataProvider(
            'CourseMember',
            array(
                'criteria' => array(
                    'condition' => 'find_in_set("teacher",roles) and courseId='.$model->id
                )
            )
        );

        // 回复光荣榜数据提供者
        $memberDataProvider = new CActiveDataProvider(
            'CourseMember',
            array(
                'criteria' => array(
                    'condition' =>  'commentNum>0',
                    'order'     =>  'commentNum DESC'
                ),
                'pagination' => array(
                    'pageSize' => 5
                ),
            )
        );

        // 课程讨论数据提供者
        $postDataProvider = new CActiveDataProvider(
            'CoursePost',
            array(
                'criteria'  =>  array(
                    'condition' =>  "courseId={$model->id}",
                    'order'     =>  'isTop DESC, addTime DESC',
                ),
            )
        );

        // CourseMember 对象
        if (!Yii::app()->user->isGuest) {
            $courseMember =  CourseMember::model()->findByAttributes(array('courseId'=>$model->id,'userId'=>Yii::app()->user->id));
        } else {
			$courseMember = new CourseMember;
        }
        // 用户是否购买课程，使用不同的header视图
        if (
            Yii::app()->user->checkAccess('courseOwner', array('course'=>$model))
            ||
            ($courseMember && $courseMember->inRoles(array('superAdmin','admin','member','teacher','student')))
        ) {
            $this->viewMenuName = '/index/_view_menu';
            $this->viewHeaderName = '/index/_view_header';
        }

        $this->render(
            'index',
            array(
                'model' =>  $model,
                'teacherDataProvider'   =>  $teacherDataProvider,
                'memberDataProvider'    =>  $memberDataProvider,
                'postDataProvider'      =>  $postDataProvider,
				'courseMember' => $courseMember,
            )
        );

    }

	public function actionAddComment($id){
		$model = $this->loadModel($id);
		$comment = new Comment();

		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];

			if($model->addComment($comment)){
				$model->upTime = time();
				$model->save();

				//发送消息
				if($model->asa('followable')){
					$follows = $model->getAllFollows();
					foreach($follows as $follow){
						if($follow->userId!=$comment->userId && $follow->userId!=$comment->referId){
							Notice::send($follow->userId, $model->entity->type."_comment_added", array('commentId'=>$comment->id));
						}
					}
				}
				//更新回复统计
				$member = CourseMember::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'courseId'=>$model->courseId));
				if($member){
					$criteria = new CDbCriteria();
					$criteria->join = "inner join {{course_post}} p on p.entityId=t.commentableEntityId";
					$criteria->condition = "p.courseId=".intval($model->courseId). " and t.userId=".Yii::app()->user->id;
					//	Comment::model()->count($criteria);

					$member->commentNum = Comment::model()->count($criteria);
					$member->save();
				}

				Yii::app()->user->setFlash('success',Yii::t('app','评论成功！'));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','抱歉，评论失败！'));
			}

		}

		$this->redirect(array('view','id'=>$model->id));

	}
	public function actionUpdate($id){
		$model=$this->loadModel($id);
		if(Yii::app()->user->checkAccess('updatePost',array('post'=>$model))){
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['CoursePost']))
			{
				$model->attributes=$_POST['CoursePost'];
				if($model->save()){
					Yii::app()->user->setFlash('success',Yii::t('app','更新成功!'));
					$this->redirect(array('view','id'=>$model->id));
				}
			}

			$this->render('update',array(
			'model'=>$model,
			'course'=>$model->course,
			));
		}
	}
	/**
	 * 置顶post
	 * @param unknown_type $id
	 * @param unknown_type $postId
	 */
	public function actionSetTop($id,$value){
		$post = CoursePost::model()->findByPk($id);
		$course = $this->loadCourse($post->courseId);
		$member = $course->findMember(array('userId'=>Yii::app()->user->id));
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
	 * 删除post
	 * @param unknown_type $id
	 * @param unknown_type $postId
	 */
	public function actionDeleteComment($id,$commentId){
		$course = $this->loadCourse($id);
		$comment = Comment::model()->find(array('join'=>'inner join ew_post p on p.entityId=t.commentableEntityId inner join ew_course g on p.postableEntityId=g.entityId',
												'condition'=>'t.id=:commentId','params'=>array('commentId'=>$commentId)));

		$post = Post::model()->findByAttributes(array('entityId'=>$comment->commentableEntityId));
		if(!$post->postableEntityId==$course->entityId){
			Yii::app()->user->setFlash('error',Yii::t('app','参数错误'));
			$this->redirect(array('post','id'=>$postId));
			Yii::app()->end();
		}
		$member = $course->findMember(array('userId'=>Yii::app()->user->id));
		if(Yii::app()->user->checkAccess('Admin') ||
		($member &&$member->inRoles(array('superAdmin','admin')))){
			if($post->deleteComment($comment)){
				Yii::app()->user->setFlash('success',Yii::t('app','删除成功！'));
				$this->redirect(array('post','id'=>$post->id));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','删除失败！'));
				$this->redirect(array('post','id'=>$post->id));
			}
		}else{
			Yii::app()->user->setFlash('error',Yii::t('app','错误,权限不足!'));
			$this->redirect(array('post','id'=>$post->id));
		}
	}


	public function actionCreateInCourse($courseId){
		$course = $this->loadCourse($courseId);
		$this->_doCreatePost($courseId);
		$dataProvider = new CActiveDataProvider('CoursePost',array('criteria'=>array('condition'=>'courseId=:courseId','params'=>array(':courseId'=>$courseId),'order'=>'isTop desc,upTime desc')));
		$this->renderPartial('_index_panel_post',array('dataProvider'=>$dataProvider));
	}

	public function actionCreateInLesson($lessonId){
		$lesson = $this->loadLesson($lessonId);
		$courseId = $lesson->courseId;
		$this->_doCreatePost($courseId,$lessonId);

		$dataProvider = new CActiveDataProvider('CoursePost',array('criteria'=>array('condition'=>'lessonId=:lessonId and courseId=:courseId','params'=>array(':lessonId'=>$lessonId,':courseId'=>$courseId),'order'=>'isTop desc,upTime desc')));

		$this->renderPartial('_items',array('dataProvider'=>$dataProvider,'lessonId'=>$lessonId));
	}

	private function _doCreatePost($courseId,$lessonId=0){
		$post = new CoursePost;
		if(isset($_POST['CoursePost'])){
			$post->attributes = $_POST['CoursePost'];
			$post->courseId = $courseId;
			$post->lessonId = $lessonId;
			$post->userId = Yii::app()->user->id;
			return  $post->save();
		}
		return false;
	}
	/**
	 * 发表文章
	 * @param unknown_type $id
	 */
	public function actionCreate($courseId=0,$lessonId=0){
		if($lessonId){
			$lesson = $this->loadLesson($lessonId);
			$course = $lesson->course;
		}else{
			$course=$this->loadCourse($courseId);
		}
		$post = new CoursePost;

		if(isset($_POST['CoursePost'])){
			$post->attributes = $_POST['CoursePost'];
			$post->userId = Yii::app()->user->id;
			if($post->save()){
				Yii::app()->user->setFlash('success',Yii::t('app','发布成功！'));
				$this->redirect(array('post/view','id'=>$post->getPrimaryKey()));
				Yii::app()->end();
			}
		}
		$this->render('create',array('model'=>$post,'course'=>$course,'lesson'=>$lesson));
	}

	/**
	 * 查看一个帖子
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function actionView($id){
		$post = $this->loadModel($id);
		//$course = $post->postableEntity->getModel();
		$course = $post->course;
		$member= $course->findMember(array('userId'=>Yii::app()->user->id));
		$member = $member ? $member : new Member();
		$followDataProvider = $post->getFollowDataProvider();
		$this->render('view',array('model'=>$post,
									'course'=>$course,
									'member'=>$member,
									'followDataProvider'=>$followDataProvider));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CoursePost::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadCourse($id)
	{
		$model=Course::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	public function loadLesson($id)
	{
		$model=Lesson::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested Lesson does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
