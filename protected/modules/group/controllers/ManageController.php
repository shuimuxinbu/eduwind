<?php

/**
 * 小组管理Controller
 */
class ManageController extends Controller
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
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * 返回外部动作列表
	 * @return array
	 */
	public function actions() {
		return array(
		'uploadFace'=>array(
					'class'=>'application.components.actions.jcrop.UploadImageAction',
					'attribute'=>'face'),
		);
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
                    'actions'=>array('create','index','view','update', 'title','setBasic','uploadFace','cropFace','setDetail','editMember',
                                    'members'),
                    'expression'=>array($this,'allowOnlyAdmin'),
		),

		array('deny',  // deny all users
                    'users'=>array('*'),
		),
		);
	}


	/**
	 * 设置基本信息设置
	 * @param integer $id
	 */
	public function actionSetBasic($id)
	{
		$group = $this->loadModel($id);
		if(isset($_POST['Group'])){
			$group->attributes = $_POST['Group'];
			if($group->save())
			Yii::app()->user->setFlash('success',Yii::t('app','保存信息成功！'));
			else {
				Yii::app()->user->setFlash('error',Yii::t('app','抱歉！保存信息失败！'));
			}
		}

		//	$cates = GroupCategory::model()->findAll(array('condition'=>'referid=0','order'=>'weight asc'));

		$this->render('setBasic',array(
			'group'=>$group,
		//	'cates'=>$cates,
		));
	}


	/**
	 * 设置用户头像设置
	 * @param integer $id
	 */
	public function actionCropFace($id){
		$model = $this->loadModel($id);
		if($model->face == $model->defaultFace){
			$this->redirect(array('uploadFace','id'=>$id));
			Yii::app()->end();
		}
		if(isset($_POST['imageId_x'])){
			Yii::import('ext.jcrop.EJCropper');
			$jcropper = new EJCropper();
			$jcropper->thumbPath = dirname($model->face)."/thumbs";
			if(!file_exists($jcropper->thumbPath)) DxdUtil::createFolders($jcropper->thumbPath);

			// get the image cropping coordinates (or implement your own method)
			$coords = $jcropper->getCoordsFromPost('imageId');
			// returns the path of the cropped image, source must be an absolute path.
			$thumbnail = $jcropper->crop($model->face, $coords);
			if($thumbnail){
				unlink($model->face);
				$model->face = $thumbnail;
				$model->save();
			}
			$this->redirect(array('uploadFace','id'=>$id));
		}
		$this->render('crop_face',array('model'=>$model));

	}


	/**
	 * 成员称号设置
	 * @param integer $id
	 */
	public function actionTitle($id)
	{
		$model = $this->loadModel($id);
		if(isset($_POST['Group']))
		{
			$model->attributes = $_POST['Group'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success', Yii::t('app','保存信息成功'));
			}else{
				Yii::app()->user->setFlash('success', Yii::t('app','保存信息成功'));
			}
		}
		$this->render('title', array('model'=>$model));
	}


	/**
	 * 设置详细信息
	 * @param integer $id
	 */
	public function actionSetDetail($id){
		$group = $this->loadModel($id);
		if(isset($_POST['Group'])){
			$group->attributes = $_POST['Group'];
			if($group->save())
			Yii::app()->user->setFlash('success',Yii::t('app','保存信息成功！'));
			else {
				Yii::app()->user->setFlash('error',Yii::t('app','抱歉！保存信息失败！'));
			}
		}

		$this->render('setDetail',array(
			'group'=>$group,
		));
	}


	/**
	 * 列举所有用户
	 * @param integer $id
	 */
	public function actionMembers($id){
		$group = $this->loadModel($id);
		//		$superAdminProvider = $group->getMemberDataProviderByRole('superAdmin');
		//		$adminProvider = $group->getMemberDataProviderByRole('admin');
		//		$memberDataProvider = $group->getMemberDataProviderByRole('member');
		$superAdminDataProvider =
		$criteria = new CDbCriteria();
		$criteria->condition="groupId=:groupId and find_in_set(:role,t.roles)";
		$criteria->params = array( ':groupId'=>$id,':role'=>'superAdmin');
		$criteria->with = 'user';
		$superAdminDataProvider =  new CActiveDataProvider("GroupMember",array('criteria'=>$criteria));		//	var_dump($result->getData());

		$criteria = new CDbCriteria();
		$criteria->condition="groupId=:groupId and find_in_set(:role,t.roles)";
		$criteria->params = array( ':groupId'=>$id,':role'=>'superAdmin');
		$criteria->with = 'user';
		$criteria->params = array( ':groupId'=>$id,':role'=>'admin');
		$adminDataProvider =  new CActiveDataProvider("GroupMember",array('criteria'=>$criteria));		//	var_dump($result->getData());

				$criteria = new CDbCriteria();
		$criteria->condition="groupId=:groupId and find_in_set(:role,t.roles)";
		$criteria->params = array( ':groupId'=>$id,':role'=>'superAdmin');
		$criteria->with = 'user';
		$criteria->params = array( ':groupId'=>$id,':role'=>'member');
		$memberDataProvider =  new CActiveDataProvider("GroupMember",array('criteria'=>$criteria));		//	var_dump($result->getData());

		$this->render('members',array(
			'group'=>$group,
			'superAdminDataProvider'=>$superAdminDataProvider,
			'adminDataProvider'=>$adminDataProvider,
			'memberDataProvider'=>$memberDataProvider,
		));
	}


	/**
	 * 列举所有用户
	 * @param integer $id
	 * @param integer $userId
	 */
	public function actionEditMember($id,$userId){
		$group = $this->loadModel($id);
		$member = GroupMember::model()->findByAttributes(array('groupId'=>$group->id,'userId'=>$userId));
		if(isset($_POST['Member'])){
			$member->attributes = $_POST['Member'];
			if($member->roles) {
				if($member->save()) Yii::app()->user->setFlash('success',Yii::t('app','保存成功！'));
				else Yii::app()->user->setFlash('error',Yii::t('app','保存失败！'));
			}
			else{
				if($member->delete()) Yii::app()->user->setFlash('success',Yii::t('app','已将用户移出小组！'));
			}
		}
		$this->layout = "/layouts/nonav_column1";
		if($member){
			$myMember = GroupMember::model()->findByAttributes(array('groupId'=>$group->id,'userId'=>Yii::app()->user->id));
				if(Yii::app()->user->checkAccess('admin')){
				$roleItems = array('superAdmin'=>Yii::t('app','超级管理员'),'admin'=>Yii::t('app','管理员'),'member'=>Yii::t('app','普通成员'));
			}else if ($myMember->inRoles(array('superAdmin'))) {
				$roleItems=array('admin'=>Yii::t('app','管理员'),'member'=>Yii::t('app','普通成员'));
			}else if($myMember->inRoles(array('admin'))){
				$roleItems=array('member'=>Yii::t('app','普通成员'));
			}
			$this->render('edit_member_fancy',array('member'=>$member,
													'roleItems'=>$roleItems));
		}
	}


	/**
	 * 课程管理首页
	 * @param integer $id
	 */
	public function actionView($id)
	{
		$this->redirect(array('setBasic','id'=>$id));
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
	/**
	 * 检查权限
	 */
	public function allowOnlyAdmin()
	{
		if(Yii::app()->user->checkAccess('admin')) return true;
		$group = $this->loadModel($_GET['id']);
//		$member = $group->findMember(array('userId'=>Yii::app()->user->id));
		$member = GroupMember::model()->findByAttributes(array('groupId'=>$group->id,'userId'=>Yii::app()->user->id));
		
		if($member && $member->inRoles(array('admin','superAdmin'))) return true;
		return false;
	}
}
