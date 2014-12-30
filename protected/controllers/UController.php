<?php

class UController extends Controller
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
		//			'rights',
			);
	}

	public function actions() {
		return array('toggleFollow'=>array(
			'class'=>'application.components.actions.ToggleFollowAction',
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
			'actions'=>array('registerOauth','tmpEmailVerify','uploadFace','cropFace'),
			'users'=>array('@'),
			),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
			'users'=>array('*',),
			)
		);
	}

	public function allowedActions()
	{
		return 'index, view';
	}

	public function actionIndex($id){
		$user = $this->loadModel($id);

		$courseDataProvider = new CArrayDataProvider($user->coursesOk);
		//		$questionDataProvider = new CArrayDataProvider($user->questions,array('keyField'=>'id'));
		//		$answerDataProvider = new CArrayDataProvider($user->answers,array('keyField'=>'id'));

		$this->render("index",array("user"=>$user,
			'courseDataProvider'=>$courseDataProvider,
		//									'questionDataProvider'=>$questionDataProvider,
		//									'answerDataProvider'=>$answerDataProvider
			));
	}
	/**
	 * 显示用户名片信息
	 */
	public function actionHoverCard(){
		$userId = isset($_POST['userid']) ? $_POST['userid'] :  $_POST['userId'];
		$user= UserInfo::model()->findByPk($userId);
		// 		Yii::app()->clientScript->scriptMap['*.js'] = false;
		$this->renderPartial('hovercard',array('user'=>$user),false,true );
	}

	/*
	 public function actionToCount(){
		$users = UserInfo::model()->findAll();
		foreach($users as $user){
		$user->answerVoteupNum = $user->getAnswerVoteupCount();
		$user->count_answer = $user->answerCount;
		$user->count_fan = $user->fanCount;
		$user->save();
		if($user->answerVoteupNum>0) echo $user->id."/".$user->answerVoteupNum."<br/>";
		}
	}*/
	/**
	 * 用户注册
	 * Enter description here ...
	 */
	public function actionRegister()
	{
		$model=new RegisterForm('register');
		global $sysSettings;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='register-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['RegisterForm']))
		{
			$model->attributes=$_POST['RegisterForm'];
			//		if($model->validate()) error_log('validate success');
			if($model->validate() && $model->register())
				//ucenter
				if(isset($sysSettings['partner']) && $sysSettings['partner']['mode']=='ucenter'){
					Yii::import('ext.ucenter.MUcenter',true);
					$uid = uc_user_register($model->name, $model->password, $model->email);
				}

				if(isset($sysSettings['mailer']['enabled']) && !$sysSettings['mailer']['enabled']){
					$this->userOk($model->email);
					$this->redirect(array('u/uploadFace'));
				}
				else{ 
					$this->redirect(array("u/verify","email"=>urlencode($model->email)));
				}
			}

			$this->render('register',array(
				'model'=>$model
				));
		}
	public function userOk($email){
		$userInfo = UserInfo::model()->findByAttributes(array('email'=>$email));
		$userInfo->verifyCode="";
		$userInfo->status = "ok";
		$userInfo->save();
		$user = User::model()->findByPk($userInfo->id);
		$user->loginWithoutPassword();
	}


	/**
	 * 邮箱验证注册
	 * Enter description here ...
	 */
	public function actionVerify($email="",$verifyCode="")
	{
		$email = urldecode($email);
		$userInfo = UserInfo::model()->findByAttributes(array('email'=>$email));
		if($userInfo->status=='frozened'){
			throw new CHttpException(404,Yii::t('app','错误！你的账号已被冻结.'));
			Yii::app()->end();
		}
		//发送邮件
		if(!$verifyCode && ($userInfo->status=="created"||$userInfo->status=="verifying")){

			if($userInfo->verifyCode=="") {
				$userInfo->verifyCode = DxdUtil::randCode(32);
			}
			$userInfo->status = "verifying";
			$userInfo->save();

			$subject = Yii::app()->params['settings']['site']['name'].Yii::t('app','邮箱验证');
			$url = Yii::app()->createAbsoluteUrl('u/verify',array('verifyCode'=>$userInfo->verifyCode,'email'=>urlencode($userInfo->email)));
			$content = $userInfo->name.Yii::t('app',"，你好：")."<br /><br/>".
			'&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t('app','感谢你注册').Yii::app()->params['settings']['site']['name'].Yii::t('app','.点击以下链接进完成邮箱验证：').'<br/><br/>'.
			'&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$url.'">'.$url.'</a><br/>'.
			'&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t('app','（如果链接无法点击，请将它拷贝到浏览器地址栏中）').'<br/><br/>'.
			'&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t('app','你的{name}帐号是{email}',array('{name}'=>Yii::app()->params['settings']['site']['name'],'{email}'=>$userInfo->email)).'<br/><br/>';

			DxdUtil::postMail($userInfo->email, $subject, $content);
			$this->render('register_verify',array('user'=>$userInfo));
			Yii::app()->end();
		}

		if($userInfo->verifyCode==$verifyCode && $userInfo->status=="verifying"){
			//验证邮件
			$this->userOk($userInfo->email);
			$this->redirect(array('u/uploadFace'));
		}

	}

	// public function userOk($email){
	// 	$userInfo = UserInfo::model()->findByAttributes(array('email'=>$email));
	// 	$userInfo->verifyCode="";
	// 	$userInfo->status = "ok";
	// 	$userInfo->save();
	// 	$user = User::model()->findByPk($userInfo->id);
	// 	$user->loginWithoutPassword();
	// }

	public function actionUploadFace(){
		$userInfo = UserInfo::model()->findByAttributes(array('id'=>Yii::app()->user->id));
		if(isset($_POST['UserInfo'])){
			$userInfo->attributes = $_POST['UserInfo'];
			$userInfo->save();
			$this->redirect(array('cropFace'));
		}
		$this->render("register_face",array('id'=>$userInfo->id,'userInfo'=>$userInfo));	

	}

	public function actionCropFace(){
		$user = UserInfo::model()->findByAttributes(array('id'=>Yii::app()->user->id));
		if(!$user->face || $user->face==$user->defaultFace) {
			Yii::app()->user->setFlash('success',Yii::t('app',"欢迎{name}加入！",array('{name}'=>$user->name)));
			$this->redirect(Yii::app()->baseUrl."/");
			Yii::app()->end();
		}
		if(isset($_POST['imageId_x'])){
			Yii::import('ext.jcrop.EJCropper');
			$jcropper = new EJCropper();
			$jcropper->thumbPath = dirname($user->face)."/thumbs";
			if(!file_exists($jcropper->thumbPath)) DxdUtil::createFolders($jcropper->thumbPath);

			// get the image cropping coordinates (or implement your own method)
			$coords = $jcropper->getCoordsFromPost('imageId');
			// returns the path of the cropped image, source must be an absolute path.
			$thumbnail = $jcropper->crop( $user->face, $coords);
			if($thumbnail){
				unlink($user->face);
				$user->face = $thumbnail;
				$user->save();
			}
			Yii::app()->user->setFlash('success',Yii::t('app',"欢迎{name}加入！",array('{name}'=>$user->name)));
			$this->redirect(Yii::app()->baseUrl."/");
			//	echo $jcropper->thumbPath;			
		//	echo $thumbnail;
		}
		$this->render('register_crop_face',array('user'=>$user));
	}

	public function actionFetchNames($term){
		$criteria=new CDbCriteria;
		$criteria->compare('name',$term,true);

		$dataProvider = new CActiveDataProvider("UserInfo", array(
			'criteria'=>$criteria,
			));
		$users = $dataProvider->getData();
		$items=array();
		foreach($users as $user){
			$items[] = $user->name;			
		}
		echo json_encode($items);
	}
	/**
	 * 社交网站登录后补充信息
	 * Enter description here ...
	 */
	public function actionRegisterOauth(){
		$userInfo = UserInfo::model()->findByPk(Yii::app()->user->id);
		$user = User::model()->findByPk(Yii::app()->user->id);
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='info-form')
		{
			echo CActiveForm::validate($userInfo);
			Yii::app()->end();
		}

		if(isset($_POST['UserInfo'])){
			$userInfo->attributes = $_POST['UserInfo'];
			$user->attributes = $_POST['User'];
			//保存信息
			//			$userinfo->email = $userInfo->email;
			//			$userinfo->introduction = $userInfo->introduction;
			//	$user = User::model()->findByPk($userInfo->id);
			$user->email = $userInfo->email;

			if($userInfo->save() && $user->save()){
				Yii::app()->user->setFlash('success',Yii::t('app','保存成功！'));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','保存失败！！'));
			}
			$this->redirect(array('site/index'));
			Yii::app()->end();
		}
		$this->render('registerOauth',array('user'=>$user,'userInfo'=>$userInfo));
	}

	/**
	 * 忘记密码
	 * Enter description here ...
	 */
	public function actionForgetPassword(){
		$model = new UserInfo;
		if(isset($_POST['UserInfo'])){
			$model->attributes = $_POST['UserInfo'];
			$user = User::model()->findByAttributes(array('email'=>$model->email));
			if(!$user){
			}else{
				$user->resetPassword = DxdUtil::randCode(32);
				if($user->save()){
					$link = $this->createAbsoluteUrl('u/resetPassword',array('resetPassword'=>$user->resetPassword,'email'=>urldecode($user->email)));
					//Yii::import('ext.email.Email');
					//$email = new Email;
					$subject = Yii::app()->params['settings']['site']['name']."-".Yii::t('app',"密码找回");
					$content = $this->renderPartial('_forget_password_email_content',array('link'=>$link),true);
					$toAddr = $user->email;
					if(DxdUtil::postMail($toAddr, $subject, $content)){
						$this->render('forgetPasswordSend',array('user'=>$user),false);
					}
				}
			}
		}else{
			$this->render('forgetPassword',array('model'=>$model));
		}
	}



	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm'])){
			
			$model->attributes=$_POST['LoginForm'];

			$user = UserInfo::model()->findByAttributes(array('email'=>$model->username));
			//刚创建或尚未验证
			if(isset($user->status) && ($user->status=="verifying"||$user->status=="created")){
				$this->redirect(array("//u/verify",'email'=>urlencode($user->email)));
				Yii::app()->end();
			}
			//被冻结
			if(isset($user->status) && $user->status=="frozened"){
				throw new CHttpException(404,Yii::t('app','抱歉！你的账号已被冻结.'));
				Yii::app()->end();
			}


			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
                //记录登录情况
                $category=EwDbLogRoute::LOGIN_MANUAL;
                $level=CLogger::LEVEL_INFO;
                $msg = serialize(array('message'=>EwDbLogRoute::LOGIN_MANUAL_MSG,'userId'=>Yii::app()->user->id));;
                Yii::log($msg,$level,$category);
                $userId = Yii::app()->user->id;
                //查看用户是否有其他的session，如果有的话，就销毁原来的session
                $oldSessionId = Yii::app()->getSession()->getUserOldSession($userId);
                Yii::app()->getSession()->destroySession($oldSessionId);

                //向session表中记录用户的id
                Yii::app()->getSession()->writeUserId($userId);

				global $sysSettings;

				if(isset($sysSettings['partner']['mode']) && $sysSettings['partner']['mode']=='ucenter'){
					//ucenter
					Yii::import('ext.ucenter.MUcenter',true);
					$script = uc_user_synlogin ( Yii::app()->user->ucenterId );
					$this->layout = "none";
					$this->render('login_success_ucenter', array(  
					 	'script' => $script,  
					 	));  
					Yii::app()->end(); 
				}else{
					$this->redirect(Yii::app()->user->returnUrl);
				}
			}
		}
// 		error_log("session_id = ".session_id());
// error_log("session=".print_r($_SESSION,true));
		// display the login form
		$this->render('login',array('model'=>$model));
	}



	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		global $sysSettings;
		Yii::app()->user->logout();

        if(isset($sysSettings['partner']['mode']) && $sysSettings['partner']['mode']=='ucenter'){
			//ucenter
			Yii::import('ext.ucenter.MUcenter',true);
			$script = uc_user_synlogout();  
			$this->render('logout_success_ucenter', array(  
				'script' => $script,  
				));  
			Yii::app()->end();  
		}else{

			//$this->redirect(Yii::app()->homeUrl);
            //ucenter
            //Yii::import('ext.ucenter.MUcenter',true);
            $script = "";//uc_user_synlogout();
            $this->render('logout_success_phpems', array(
                'script' => $script,
            ));
            Yii::app()->end();
        }
	}

	/**
	 * 重设密码
	 * Enter description here ...
	 * @param unknown_type $resetPassword
	 * @param unknown_type $email
	 */
	public function actionResetPassword($resetPassword,$email){
		$model = User::model()->findByAttributes(array('email'=>urldecode($email),'resetPassword'=>$resetPassword));
		if(isset($_POST['User'])){
			$model->attributes = $_POST['User'];
			$model->resetPassword = DxdUtil::randCode(32);
			if($model->save()){
				Yii::app()->user->setFlash('success',Yii::t('app','密码重设成功'));
				$this->redirect('login');
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','抱歉，密码重设失败！'));
			}
		}

		$this->render('resetPassword',array('model'=>$model));
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
		$model=UserInfo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}
