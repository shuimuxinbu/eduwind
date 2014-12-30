<?php

/**
 * IndexController
 */
class IndexController extends Controller
{
	/**
	 * @var string layout文件
	 */
	public $layout='//layouts/column1';


	/**
	 * 过滤器规则
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}


	/**
	 * 当前控制器的访问规则

	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
		array('allow',
                    'actions'=>array('index', 'list', 'view','post','category','hot','course', 'member'),
                    'users'=>array('*'),
		),
		array('allow',
                    'actions'=>array('create','me','join','quit','setFace','created','admin','addPost','deletePostComment',
                                     'updateMark','deletePost','setTopPost','my'),
                    'users'=>array('@'),
		),
		array('deny',  // deny all users
                    'users'=>array('*'),
		),
		);
	}


	/**
	 * 返回外部动作列表
	 * @return array
	 */
	public function actions() {
	}


	/**
	 * 小组 讨论区页面
	 * @param integer $id 小组ID
	 */
	public function actionView($id)
	{
		$group=$this->loadModel($id);
		$member = GroupMember::model()->findByAttributes(array('groupId'=>$id,'userId'=>Yii::app()->user->id));
		if(!$member) $member = new GroupMember();
		$dataProvider   =   $group->getPostDataProvider(array(
            'criteria'      =>  array(
                'order'     =>  'isTop desc,upTime desc',
		),
            'pagination'    =>  array(
                'pageSize'  =>  20,
		),
		));

		$this->render('view', array(
			'dataProvider'          =>  $dataProvider,
            'group'                 =>  $group,
			'member'                =>  $member,
		));
	}


	/**
	 * 小组 课程收藏区页面
	 * @param integer $id 小组ID
	 */
	public function actionCourse($id)
	{
		$group=$this->loadModel($id);
		$member = GroupMember::model()->findByAttributes(array('groupId'=>$id,'userId'=>Yii::app()->user->id));
		if(!$member) $member = new GroupMember();

		$courseDataProvider =   new CArrayDataProvider($group->courses, array('keyField'=>'id', 'pagination'=>array('pageSize'=>6)));

		$this->render('course', array(
            'group'         =>  $group,
			'member'        =>  $member,
			'dataProvider'  =>  $courseDataProvider,
		));
	}


	/**
	 * 小组 小组成员页面
	 * @param integer $id 小组ID
	 */
	public function actionMember($id)
	{
		$group=$this->loadModel($id);
		$member = GroupMember::model()->findByAttributes(array('groupId'=>$id,'userId'=>Yii::app()->user->id));
		if(!$member) $member = new GroupMember();

		$user = UserInfo::model()->findByPk($id);
		//		$dataProvider = $group->getMemberDataProvider(array('criteria'=>array('order'=>'t.addTime desc'), 'pagination'=>array('pageSize'=>12)));
		$dataProvider = new CActiveDataProvider('GroupMember',array('criteria'=>array('condition'=>'groupId=:groupId','order'=>'t.addTime desc','params'=>array('groupId'=>$id)),
																					 'pagination'=>array('pageSize'=>20)));
		$this->render('member', array(
            'group'         =>  $group,
            'member'        =>  $member,
            'user'          =>  $user,
			'dataProvider'  =>  $dataProvider,
		));
	}


	/**
	 * 加入小组处理
	 * @param integer $id 小组ID
	 */
	public function actionJoin($id)
	{
		$group = $this->loadModel($id);
		$member = new GroupMember();
		$member->groupId = $group->id;
		$member->userId = Yii::app()->user->id;
		$member->setArrRoles(array('member'));
		if($member->save()){
	//		$group->memberNum = GroupMember::model()->count(array('groupId'=>))
			$group->memberNum = $group->memberCount;
			$group->save();
			Yii::app()->user->setFlash('success',Yii::t('app','加入{name}小组成功！',array("{name}"=>$group->name)));
		}else{
			Yii::app()->user->setFlash('error',Yii::t('app','加入{name}小组失败！',array("{name}"=>$group->name)));
		}
		$this->redirect(array('index/view','id'=>$group->id));

	}


	/**
	 * 退出小组处理
	 * @param integer $id 小组ID
	 */
	public function actionQuit($id){
		$group = $this->loadModel($id);
		$member = GroupMember::model()->findByAttributes(array('groupId'=>$id,'userId'=>Yii::app()->user->id));
		if($member){
			if($member->inRoles(array('superAdmin'))){
				Yii::app()->user->setFlash('error',Yii::t('app','超级管理员不能退出小组'));
			}elseif($member->delete()){
				Yii::app()->user->setFlash('success',Yii::t('app','退出 {name} 小组成功！',array('{name}'=>$group->name)));
			}else {
				Yii::app()->user->setFlash('error',Yii::t('app','退出 {name} 小组失败！',array('{name}'=>$group->name)));
			}
		}
		$this->redirect(array('index/view','id'=>$group->id));
	}



/**
 * 创建小组页面和处理
 */
public function actionCreate()
{
	$model=new Group;

	if(isset($_POST['Group']))
	{
		$model->attributes=$_POST['Group'];
		$model->addTime = time();
		$model->userId = Yii::app()->user->id;
		$model->status = "apply";
		if($model->save()) {
//			$model->addMember(Yii::app()->user->id,array('superAdmin'));
		$member = new GroupMember();
		$member->groupId = $model->id;
		$member->userId = Yii::app()->user->id;
		$member->setArrRoles(array('superAdmin'));
		$member->save();
			$admins = UserInfo::getAllAdmins();
			foreach($admins as $user){
				Notice::send($user->id, 'group_apply',array('groupId'=>$model->getPrimaryKey()));
			}
			Yii::app()->user->setFlash('success',Yii::t('app','申请已提交，请继续完善小组资料'));
			$this->redirect(array('view','id'=>$model->id));
		}
	}

	$user = UserInfo::model()->findByPk(Yii::app()->user->id);
	$this->render('create',array(
			'model'=>$model,
			'user'=>$user,
	));
}


/**
 * 删除小组处理
 * @param integer $id 小组ID
 */
public function actionDelete($id)
{
	$this->loadModel($id)->delete();

	// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
	if(!isset($_GET['ajax']))
	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
}


/**
 * 小组模块首页
 */
public function actionIndex()
{
	$criteria = new CDbCriteria();
	$criteria->order ='upTime desc,commentNum desc' ;
	$criteria->join = "left join ew_group g on t.groupId=g.id";
	$criteria->condition = "g.status='ok'";
	// 新帖子数据提供者
	$newPostDataProvider = new CActiveDataProvider('Post',array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>15,
	)
	));

	// 热门小组数据提供者
	$hotGroupDataProvider = new CActiveDataProvider(
            'Group',
	array(
                'pagination'    =>  array('pageSize'=>5),
                'criteria'      =>  array(
                    'with'  =>  array('user'),
                    'condition' =>  't.status="ok"',
                    'order' =>  't.memberNum desc, t.addTime desc'
                    )
                    )
                    );

                    $this->render('index',array(
            'hotGroupDataProvider'  =>  $hotGroupDataProvider,
            'newPostDataProvider'=>$newPostDataProvider,
                    ));
}

/**
 * 全部小组页面
 */
public function actionList()
{
	// 所有小组数据提供者
	$allGroupDataProvider = new CActiveDataProvider(
            'Group',
	array(
                'pagination'    =>  array('pageSize'=>30),
                'criteria'      =>  array(
	                    'condition' =>  't.status="ok"',
                    	'order' =>  'isTop desc, memberNum desc, addTime desc'
                    )
                    )
                    );
                    // 热门小组数据提供者
                    $hotGroupDataProvider = new CActiveDataProvider(
            'Group',
                    array(
                'pagination'    =>  array('pageSize'=>5),
                'criteria'      =>  array(
                    'with'  =>  array('user'),
                    'condition' =>  't.status="ok"',
                    'order' =>  't.memberNum desc, t.addTime desc'
                    )
                    )
                    );

                    $this->render(
            'list',
                    array(
                'allGroupDataProvider'  =>  $allGroupDataProvider,
                'hotGroupDataProvider'  =>  $hotGroupDataProvider,
                    )
                    );
}

/**
 * 我的小组页面
 */
public function actionMe()
{
	// 新帖子数据提供者
/*	$newPostDataProvider = new CActiveDataProvider(
            'Post',
	array(
                'criteria'=>array('order'=>'upTime desc,commentNum desc'),
                'pagination'=>array('pageSize'=>15)
	)
	);*/
	$criteria = new CDbCriteria();
	$criteria->join = "left join ew_group_member m on m.groupId=t.groupId";
	$criteria->condition = "m.userId=".Yii::app()->user->id;
	$criteria->order = 'upTime desc,commentNum desc';
	$newPostDataProvider = new CActiveDataProvider('Post',array('criteria'=>$criteria));


	
	// 我的小组数据提供者
	$criteria = new CDbCriteria();
	$criteria->join = "left join ew_group_member m on m.groupId=t.id";
	$criteria->condition = "m.userId=".Yii::app()->user->id;
	$criteria->order = 'addTime desc';
	$myGroupDataProvider = new CActiveDataProvider('Group',array('criteria'=>$criteria));

	$this->render(
            'me',
	array(
                'newPostDataProvider' => $newPostDataProvider,
                'myGroupDataProvider' => $myGroupDataProvider,
	)
	);
}


/**
 * Category
 * @param integer $categoryId
 */
public function actionCategory($categoryId=0){
	$category = Category::model()->findByPk($categoryId);
	if($categoryId!=0):
	$dataProvider=new CActiveDataProvider('Group',array(
                'pagination'=>array('pageSize'=>24),
                'criteria'=>array(
                    'with'=>array('user'),
                    'condition'=>'t.status="ok" and categoryId='.$categoryId,
                    'order'=>'t.memberNum desc,t.addTime desc'
                    )
                    ));
                    else:
                    $dataProvider=new CActiveDataProvider('Group',array(
                'pagination'=>array('pageSize'=>24),
                'criteria'=>array(
                    'with'=>array('user'),
                    'condition'=>'t.status="ok"',
                    'order'=>'t.memberNum desc,t.addTime desc'
                    )
                    ));
                    endif;

                    $firstCategories = Category::model()->findAllByAttributes(array('type'=>'group','parentId'=>0));
                    $this->render('category',array(
            'dataProvider'=>$dataProvider,
            'myGroupDataProvider'=>$this->getMyGroupDataProvider(),
            'category'=>$category,
            'firstCategories'=>$firstCategories,
            'categoryId'=>$categoryId,
                    ));
}


/**
 * 获取热闹帖子数据
 */
public function actionHot(){
	$category = Category::model()->findByPk($categoryId);
	if($categoryId!=0):
	$dataProvider=new CActiveDataProvider('Group',array('pagination'=>array('pageSize'=>24),
                'criteria'=>array(
                    'with'=>array('user'),
                    'condition'=>'t.status="ok" and categoryId='.$categoryId,
                    'order'=>'t.memberNum desc,t.addTime desc'
                    )
                    ));
                    else:
                    $dataProvider=new CActiveDataProvider('Group',array('pagination'=>array('pageSize'=>24),
                'criteria'=>array(
                    'with'=>array('user'),
                    'condition'=>'t.status="ok"',
                    'order'=>'t.memberNum desc,t.addTime desc'
                    )
                    ));
                    endif;

                    $firstCategories = Category::model()->findAllByAttributes(array('type'=>'group','parentId'=>0));
                    $this->render('category',array(
            'dataProvider'=>$dataProvider,
            'myGroupDataProvider'=>$this->getMyGroupDataProvider(),
            'category'=>$category,
            'firstCategories'=>$firstCategories,
            'categoryId'=>$categoryId,
                    ));
}


/**
 * MyGroupDataProvider
 */
public function getMyGroupDataProvider(){
	$myGroupDataProvider =null;
	if(!Yii::app()->user->isGuest)
	{
		$user = UserInfo::model()->findByPk(Yii::app()->user->id);
		$myGroupDataProvider = new CActiveDataProvider('Group',array(
                'criteria'=>array(
                    'join'=>'inner join ew_member m on m.memberableEntityId=t.entityId',
		//	'condition'=>'t.status="ok" AND m.userId=:userId',
                    'condition'=>'m.userId=:userId',
                    'params' => array(':userId'=>$user->id)
		),
                'pagination'=>array('pageSize'=>18)
		));
	}
	return $myGroupDataProvider;
}


/**
 * ToggleCourse
 * @param integer $id
 * @param integer $courseId
 */
public function actionToggleCourse($id,$courseId){
	$group = $this->loadModel($id);
	$course = Course::model()->findByPk($courseId);
	if($course){
		$groupCourse = new GroupCourse;
		$groupCourse->groupId = $id;
		$groupCourse->courseId = $courseId;
		$groupCourse->addTime = time();
		$groupCourse->userId = Yii::app()->user->id;
		if($groupCourse->save())
		Yii::app()->user->setFlash('success','');
	}
}


/**
 * Creates a new model.
 * If creation is successful, the browser will be redirected to the 'view' page.
 * @param integer $id
 */
public function actionUpdateIntroduction($id)
{
	$model=$this->loadModel($id);

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if(isset($_POST['Group']))
	{
		$model->attributes=$_POST['Group'];
		if($model->save())
		$this->redirect(array('view','id'=>$model->id));
	}

	$this->render('update_introduction',array(
			'model'=>$model,
	));
}


/**
 * Returns the data model based on the primary key given in the GET variable.
 * If the data model is not found, an HTTP exception will be raised.
 * @param integer $id the ID of the model to be loaded
 * @return Group the loaded model
 * @throws CHttpException
 */
public function loadModel($id)
{
	$model=Group::model()->findByPk($id);
	if($model===null)
	throw new CHttpException(404,'The requested page does not exist.');
	return $model;
}


/**
 * Performs the AJAX validation.
 * @param Group $model the model to be validated
 */
protected function performAjaxValidation($model)
{
	if(isset($_POST['ajax']) && $_POST['ajax']==='group-form')
	{
		echo CActiveForm::validate($model);
		Yii::app()->end();
	}
}
}
