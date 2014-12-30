<?php

class MeController extends Controller
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
		//'rights',
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
            //用于客户端向服务器询问自己是否在线
            array('allow',  // allow all users to perform 'checkLogin' actions
                'actions'=>array('checkLogin'),
                'users'=>array('*'),
            ),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'users'=>array('@'),
		),
		array('deny'  // deny all users
		),
		);
	}

	public function actions() {
		return array(
		'uploadFace'=>array(
					'class'=>'application.components.actions.jcrop.UploadImageAction',
					'attribute'=>'face',
					'id'=>Yii::app()->user->id),
		);
	}

	/**
	 *
	 */
	public function actionReceiveMail()
	{
		$model = $this->loadModel(Yii::app()->user->id);

        if (isset($_POST['UserInfo'])) {
            $model->receiveMailNotify = $_POST['UserInfo']['receiveMailNotify'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '操作成功');
            } else {
                Yii::app()->user->setFlash('error', '操作失败');
            }
        }

		$this->render(
            'receiveMail',
            array(
                'model' =>  $model
            )
		);
	}



	/**
	 * 设置用户头像
	 * @param unknown_type $courseId
	 */
	public function actionCropFace($id){
		$model = $this->loadModel($id);
		if($model->face == $model->defaultFace || !$model->face){
			Yii::app()->user->setFlash('error',Yii::t('app','请先上传头像！'));
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
			$thumbnail = $jcropper->crop($model->face, $coords);
			if($thumbnail){
				unlink($model->face);
				$model->face = $thumbnail;
				$model->save();
			}
			$this->redirect(array('uploadFace'));
		}
		$this->render('crop_face',array('model'=>$model));

	}

	/*	public function actionCropFace(){
	 $model = UserInfo::model()->findByAttributes(array('id'=>Yii::app()->user->id));
		if(isset($_POST['imageId_x'])){
		Yii::import('ext.jcrop.EJCropper');
		$jcropper = new EJCropper();
		//$jcropper->thumbPath = dirname(Yii::app()->basePath."/../".$model->face)."/thumbs";
		$jcropper->thumbPath = dirname($model->face)."/thumbs";

		if(!file_exists($jcropper->thumbPath)) DxdUtil::createFolders($jcropper->thumbPath);

		// some settings ...
		$jcropper->jpeg_quality = 95;
		$jcropper->png_compression = 8;

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
		$this->redirect(array('setFace'));

		}
		$this->render('crop_face',array('model'=>$model));
		}
		*/
	public function actionIndex(){
		$this->redirect(array('courseJoin'));
		/*		$userId or $userId=Yii::app()->user->id;
		 if(!$userId){
			$this->redirect(array('/course/index'));
			Yii::app()->end();
			}
			$user = UserInfo::model()->with('coursesLearning.user')->findByPk($userId);
			$courseDataProvider=new CArrayDataProvider($user->coursesLearning,array('keyField'=>'courseId'));
			$this->render("index",array('user'=>$user,'courseDataProvider'=>$courseDataProvider));
			*/
	}
	/**
	 * 在学的课程
	 * Enter description here ...
	 */
	public function actionCourseCollect(){
		//$user = UserInfo::model()->with('coursesLearning.user')->findByPk(Yii::app()->user->id);
		//$courseDataProvider=new CArrayDataProvider($user->coursesLearning,array('keyField'=>'courseId','pagination'=>array('pageSize'=>100)));
		$courseDataProvider = Course::model()->getCollectionDataProvider(Yii::app()->user->id);
		$user = UserInfo::model()->findByPk(Yii::app()->user->id);
		$this->render("course_collect",array('user'=>$user,
											'courseDataProvider'=>$courseDataProvider));
		//		$this->renderPartial("courseLearning",array('courseDataProvider'=>$courseDataProvider),false,true);
	}



	/**
	 * 管理的课程
	 */
	public function actionCourseAdmin(){
		$courseDataProvider = new CActiveDataProvider('Course',array(
														'criteria'=>array('join'=>'inner join ew_member m on t.entityId=m.memberableEntityId',
																		  'condition'=>'find_in_set("superAdmin",roles) || find_in_set("admin",roles)',
																		  'order'=>'m.addTime desc'))
		);
		$user = UserInfo::model()->findByPk(Yii::app()->user->id);
		$this->render("course_collect",array('user'=>$user,
											'courseDataProvider'=>$courseDataProvider));
	}

	/**
	 * 暂停的课程
	 * Enter description here ...
	 */
	public function actionCourseStoped(){
		$user = UserInfo::model()->with('coursesStoped.user')->findByPk(Yii::app()->user->id);
		$courseDataProvider=new CArrayDataProvider($user->coursesStoped,array('keyField'=>'courseId','pagination'=>array('pageSize'=>100)));

		$this->renderPartial("courseStoped",array('courseDataProvider'=>$courseDataProvider),false,true);
	}

	/**
	 * 我的课程
	 * Enter description here ...
	 */
	public function actionCourseCreated(){
		$user = UserInfo::model()->with('courses.user')->findByPk(Yii::app()->user->id);
		$courseDataProvider=new CArrayDataProvider($user->courses,array('keyField'=>'courseId'));

		$this->renderPartial("courseCreated",array('courseDataProvider'=>$courseDataProvider),false,true);
	}

	/**
	 * 设为已学
	 * Enter description here ...
	 * @param unknown_type $courseId
	 */
	public function actionSetLearned($courseId){
		//$user = UserInfo::model()->findByPk($userId);
		$learn = CourseLearn::model()->findByAttributes(array('courseId'=>$courseId,'userId'=>Yii::app()->user->id));
		$learn->status = "learned";
		if($learn->save()){
			echo true;
			Yii::app()->end();
		}
	}

	/**
	 * 设为已学
	 * Enter description here ...
	 * @param unknown_type $courseId
	 */
	public function actionSetLearning($courseId){
		//$user = UserInfo::model()->findByPk($userId);
		$learn = CourseLearn::model()->findByAttributes(array('courseId'=>$courseId,'userId'=>Yii::app()->user->id));
		$learn->status = "learning";
		if($learn->save()){
			echo true;
			Yii::app()->end();
		}
	}

	/**
	 * 设为中止
	 * Enter description here ...
	 * @param unknown_type $courseId
	 */
	public function actionSetStoped($courseId){
		//$user = UserInfo::model()->findByPk($userId);
		$learn = CourseLearn::model()->findByAttributes(array('courseId'=>$courseId,'userId'=>Yii::app()->user->id));
		$learn->status = "stoped";
		if($learn->save()){
			echo true;
			Yii::app()->end();
		}
	}

	/**
	 * 设置用户基本信息
	 * Enter description here ...
	 */
	public function actionSetBasic(){
		//		$model = new UserInfo
		$user = UserInfo::model()->findByPk(Yii::app()->user->id);

		if(isset($_POST['UserInfo'])){
			$user->attributes = $_POST['UserInfo'];
			if($user->save()){
				Yii::app()->user->setFlash('success',Yii::t('app','保存信息成功！'));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','保存信息失败！'));
			}

		}
		$this->render('setBasic',array('model'=>$user));
	}

    public function actionCheckLogin() {
        $bIsGuest = false;
        if (Yii::app()->user->isGuest) {	//如果是未登录
            $bIsGuest = true;
        }
        echo json_encode(array('isGuest'=>$bIsGuest));
    }

	public function loadModel($id)
	{
		$model=UserInfo::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
