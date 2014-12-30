<?php

class IndexController extends CaController
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
				'actions'=>array('index','view','create','update','setBasic',
								'setDetail','members','editMember','uploadFace','cropFace',
								'setFee','addMember','deleteMember'),
				'expression'=>array($this,'allowOnlyAdmin'),
		),
		array('deny',  // deny all users
				'users'=>array('*'),
		),
		);
	}
	//controller
	/*	function init(){
	if(isset($_POST['SESSION_ID'])){
	$session=Yii::app()->getSession();
	$session->close();
	$session->sessionID = $_POST['SESSION_ID'];
	$session->open();
	}
	}*/
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->redirect(array('//course/view','id'=>$id));
	}


	/**
	 * 设置基本信息
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionSetBasic($id)
	{
		$course = $this->loadModel($id);
		if(isset($_POST['Course'])){
			$course->attributes = $_POST['Course'];
			if(!isset($_POST['Course']['categoryId'])) $course->categoryId = $_POST['parentId'];
			if($course->save())
			Yii::app()->user->setFlash('success',Yii::t('app','保存信息成功！'));
			else {
				Yii::app()->user->setFlash('error',Yii::t('app','抱歉！保存信息失败！'));
			}
		}

		$categories = Category::model()->findAll(array('condition'=>'type="course"','order'=>'weight asc'));

		$this->render('setBasic',array(
			'course'=>$course,
			'categories'=>$categories,
		));
	}


	/**
	 * 设置课程头像
	 * @param unknown_type $courseId
	 */
	/*	public function actionSetFace($id){
		$course = $this->loadModel($id);

		if(!empty($_FILES) || (isset($_GET["_method"]) && $_GET["_method"] == "delete")){
		Yii::import('xupload.actions.XUploader');
		$uploader= new XUploader();
		$result = $uploader->run(array(
		'path' =>Yii::app() -> getBasePath() . "/../uploads/course/face",
		'publicPath' => Yii::app() -> getBaseUrl() . "/uploads/course/face",
		));
		//处理数据库
		$course->face = $uploader->isDeleting() ? "" :substr($result['url'],strpos($result['url'],'/uploads/'));
		$course->save();

		}else{
		$this->layout = "/layouts/nonav_column1";
		$this->render('setFace',array('course'=>$course));
		}
		}*/

	public function actionUploadFace($id){
		$model =$this->loadModel($id);
		if(isset($_POST['Course'])){
			$model->attributes = $_POST['Course'];
			if($model->save()){
				$this->redirect(array('cropFace','id'=>$id));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','上传失败！'));
			}
		}
		$this->render('upload_face',array('model'=>$model));
	}

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
				//	$model->face = DxdUtil::getRelativePath(Yii::app()->basePath."/../",$thumbnail);
				$model->face = $thumbnail;
				$model->save();
			}
			$this->redirect(array('uploadFace','id'=>$id));

		}
		$this->render('crop_face',array('model'=>$model));
	}

	/**
	 * 设置详细信息
	 * @param unknown_type $id
	 */
	public function actionSetDetail($id){
		$course = $this->loadModel($id);
		if(isset($_POST['Course'])){
			$course->attributes = $_POST['Course'];
			if($course->save())
			Yii::app()->user->setFlash('success',Yii::t('app','保存信息成功！'));
			else {
				Yii::app()->user->setFlash('error',Yii::t('app','抱歉！保存信息失败！'));
			}
		}

		$this->render('setDetail',array(
			'course'=>$course,
		));
	}

	/**
	 * 列举所有用户
	 * @param unknown_type $id
	 */
	public function actionMembers($id){
		$course = $this->loadModel($id);
		//		$superAdminProvider = $course->getMemberDataProviderByRole('superAdmin');
		$superAdminDataProvider = new CActiveDataProvider('CourseMember',array('criteria'=>array('condition'=>"courseId=$course->id and find_in_set('superAdmin',t.roles)")));
		//		$adminProvider = $course->getMemberDataProviderByRole('admin');
		$adminDataProvider = new CActiveDataProvider('CourseMember',array('criteria'=>array('condition'=>"courseId=$course->id and find_in_set('admin',t.roles)")));
		$teacherDataProvider = new CActiveDataProvider('CourseMember',array('criteria'=>array('condition'=>"courseId=$course->id and find_in_set('teacher',t.roles)")));

		$studentDataProvider = new CActiveDataProvider('CourseMember',array('criteria'=>array('condition'=>"courseId=$course->id and find_in_set('student',t.roles)")));
		//		$MemberDataProvider = $course->getMemberDataProviderByRole('member');
		$otherDataProvider = new CActiveDataProvider('CourseMember',array('criteria'=>array('condition'=>"courseId=$course->id and (not (find_in_set('student',t.roles) or find_in_set('student',t.roles) or find_in_set('admin',t.roles) or find_in_set('teacher',t.roles) or find_in_set('superAdmin',t.roles)))")));

		$this->render('members',array(
			'course'=>$course,
			'superAdminDataProvider'=>$superAdminDataProvider,
			'adminDataProvider'=>$adminDataProvider,
			'teacherDataProvider'=>$teacherDataProvider,
			'studentDataProvider'=>$studentDataProvider,
			'otherDataProvider'=>$otherDataProvider,
		));
	}

	/**
	 * 列举所有用户
	 * @param unknown_type $id
	 */
	public function actionEditMember($id,$userId){
		$course = $this->loadModel($id);
		$member = $course->findMember(array('userId'=>$userId));
		if(isset($_POST['CourseMember'])){
			$member->attributes = $_POST['CourseMember'];
			$member->arrRoles = $_POST['CourseMember']['arrRoles'];
			if($member->save()) Yii::app()->user->setFlash('success',Yii::t('app','保存成功！'));
			else Yii::app()->user->setFlash('error',Yii::t('app','保存失败！'));
		}
		$this->layout = "/layouts/nonav_column1";
		if($member){
			$myMember = $course->findMember(array('userId'=>Yii::app()->user->id));
			if(Yii::app()->user->checkAccess('admin')){
				$roleItems = array('superAdmin'=>Yii::t('app','超级管理员'),'admin'=>Yii::t('app','管理员'),'teacher'=>Yii::t('app','教师'),'student'=>Yii::t('app','学员'));
			}else if ($myMember->inRoles(array('superAdmin'))) {
				$roleItems=array('admin'=>Yii::t('app','管理员'),'teacher'=>Yii::t('app','教师'),'student'=>Yii::t('app','学员'));
			}else if($myMember->inRoles(array('admin'))){
				$roleItems=array('teacher'=>Yii::t('app','教师'),'student'=>Yii::t('app','学员'));
			}
			$this->render('edit_member_fancy',array('member'=>$member,
													'roleItems'=>$roleItems));
		}
	}

	public function actionAddMember($id){
		if(isset($_POST['CourseMember'])){
			$model = new CourseMember();
			$model->attributes = $_POST['CourseMember'];
			$model->arrRoles = $_POST['CourseMember']['arrRoles'];
			$user = UserInfo::model()->findByAttributes(array('name'=>$_POST['userName']));
			if(!$user) {
				Yii::app()->user->setFlash('error',Yii::t('app','抱歉！该用户不存在！'));
			}else{
				$model->userId = $user->id;
				$model->startTime = time();
				$model->courseId = $id;
				if(CourseMember::model()->findByAttributes(array('userId'=>$user->id,'courseId'=>$model->courseId))){
					Yii::app()->user->setFlash('error',Yii::t('app','该名成员已经存在！'));
				}else if($model->save()){
					Yii::app()->user->setFlash('success',Yii::t('app','添加成功'));
				}else{
					Yii::app()->user->setFlash('error',Yii::t('app','抱歉，添加失败'));
				}
			}
			$this->redirect(array('members','id'=>$id));

		}
	}


	public function actionDeleteMember($id,$userId){
		$member = CourseMember::model()->findByAttributes(array('courseId'=>$id,'userId'=>$userId));
		if($member && $member->delete())
		Yii::app()->user->setFlash('success',Yii::t('app','删除成功！'));
		else
		Yii::app()->user->setFlash('error',Yii::t('app','删除失败！'));
		$this->redirect(array('members','id'=>$id));
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*	public function actionUpdate($id)
	 {
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Course']))
		{
		$model->attributes=$_POST['Course'];
		if($model->save())
		$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
		'model'=>$model,
		));
		}
		*/
	public function actionSetFee($id){
		$course = $this->loadModel($id);
		if(isset($_POST['Course'])){
			$course->attributes = $_POST['Course'];
			if($course->save())
			Yii::app()->user->setFlash('success',Yii::t('app','保存成功！'));
			else {
				Yii::app()->user->setFlash('error',Yii::t('app','抱歉！保存失败！'));
			}
		}

		$this->render('set_fee',array(
			'course'=>$course,
		));
	}



	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	/*	public function actionDelete($id)
	 {
		if(Yii::app()->request->isPostRequest)
		{
		// we only allow deletion via POST request
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
		*/

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Course::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * 检查权限
	 */
	public function allowOnlyAdmin(){
		if(Yii::app()->user->checkAccess('admin')) return true;
		$course = $this->loadModel(intval($_GET['id']));
		$member = $course->findMember(array('userId'=>Yii::app()->user->id));
		if($member && $member->inRoles(array('admin','superAdmin'))) return true;
		return false;
	}
}
