<?php

class OauthController extends Controller
{
	public $homePage = array("site/index");
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
		//'postOnly + delete', // we only allow deletion via POST request
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

		array('allow',  // allow all users
						'users'=>array('*'),
		),
		);
	}

	/**
	 * 处理人人网登录事宜
	 * Enter description here ...
	 * @throws CHttpException
	 */
	public function actionRennAuth()
	{
		$rennService = new RennService();
		$rennClient = $rennService->getClient();

		// 处理code -- 根据code来获得token
		if (isset ( $_REQUEST ['code'] )) {
			$keys = array ();
			// 获得code
			$keys ['code'] = $_REQUEST ['code'];
			$keys ['redirect_uri'] = Yii::app()->createAbsoluteUrl('/oauth/rennAuth');
			try {
				// 根据code来获得token
				$token = $rennClient->getTokenFromTokenEndpoint ( 'code', $keys );
			} catch ( RennException $e ) {
				error_log($e->getTraceAsString());
				throw new CHttpException(403,Yii::t('app','没有得到授权，不能访问'));
				Yii::app()->end();
			}
		}

		// 获得用户接口
		$userService = $rennClient->getUserService ();
		// 获得当前登录的人人用户信息
		try {
			$rennUser = $userService->getUserLogin ();
		} catch (Exception $e) {
			throw new CHttpException(403,Yii::t('app','没有得到授权，不能访问'));
			Yii::app()->end();
		}


		if (isset($rennUser)) {
			//检查是否为新用户
			//			$rrOauth = Oauth::model()->find('rrid=:rrid',array('rrid'=>$rennUser['id']));


			$userInfo = UserInfo::model()->findByAttributes(array('rennId'=>$rennUser['id']));
			//如果是新用户，在站内创建一个对应用户

			if (!$userInfo) {
				$transaction = Yii::app ()->db->beginTransaction ();
				try{
					$user = new User();
					$user->email = 'RRId'.$rennUser['id'].'@daxidao.com';
					$user->password = DxdUtil::randCode(32);
					$user->salt = DxdUtil::randCode(32);
					$userSaved = ($user->validate() && $user->save());
					$userInfo = new UserInfo();
					$userInfo->id = $user->getPrimaryKey();
					$userInfo->email = $user->email;
					$userInfo->name = $rennUser['name'];
					$userInfo->addTime = time();
					$userInfo->rennId = $rennUser['id'];
					$userInfo->status = 'ok';
					$userInfoSaved = $userInfo->save();


					if(!$userSaved || !$userInfoSaved) {
						Yii::app()->user->setFlash('error',Yii::t('app','抱歉，创建用户失败'));
						throw new Exception ( Yii::t('app','创建用户失败!') );
					}
					$transaction->commit();
				}catch (Exception $e){
					$transaction->rollback ();
					$this->redirect(Yii::app()->baseUrl);
					Yii::app()->end();
				}
			}
				
			//站内用户登录
	/*		$identity=new UserIdentity($userInfo->email,'somepassword');
			$identity->authenticate(true);

			if($identity->errorCode===UserIdentity::ERROR_NONE)
			{
				//$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
				Yii::app()->user->login($identity, 0);
				//print_r(Yii::app()->user);
			}*/
			$user = User::model()->findByAttributes(array('email'=>$userInfo->email));
			$user->loginWithoutPassword();

		}
		//如果还没有填写email
		if($userInfo->noEmail()){
			$this->redirect(array('u/registerOauth'));
			Yii::app()->end();
		}
		Yii::app()->user->setFlash('success',Yii::t('app','人人网登录成功！'));
		$this->redirect($this->homePage);

	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
	// return the filter configuration for this controller, e.g.:
	return array(
	'inlineFilterName',
	array(
	'class'=>'path.to.FilterClass',
	'propertyName'=>'propertyValue',
	),
	);
	}

	public function actions()
	{
	// return external action classes, e.g.:
	return array(
	'action1'=>'path.to.ActionClass',
	'action2'=>array(
	'class'=>'path.to.AnotherActionClass',
	'propertyName'=>'propertyValue',
	),
	);
	}
	*/
	//从samebook以cookie方式登录
	public function actionCookieSamebook(){
		//	Yii::app()->user->isGuest or Yii::app()->end();
		//	$uid = intval($uid);
		if(isset($_POST['Cookie'])){
			$pwd = $_POST['Cookie']['pwd'];
			$uid = $_POST['Cookie']['uid'];
			$samebookClient = Yii::app()->samebookclient->getClient();
			if($samebookClient->cookieAuthenticate($uid,$pwd)){
				$samebookUser = $samebookClient->getUser($uid);

				$this->connectSamebookUser($samebookUser);

				$userInfo = UserInfo::model()->findByAttributes(array('email'=>$samebookUser['email']));
				//站内用户登录
				$this->loginUserWithoutPwd($userInfo->email);
				//跳转到主页
				//$this->redirect($this->homePage);
				//$this->renderPartial('_cookieSamebook');
				echo 'login_success';
				Yii::app()->end();
			}
		}
		//		$this->renderPartial('_cookieSamebook');
	}


	//向daxidao数据库插入一条samebook的用户记录
	protected function connectSamebookUser($samebookUser){
		$user = User::model()->findByAttributes(array('email'=>$samebookUser['email']));
		if(!$user){
			$user = new User;
			$user->email = $samebookUser['email'];
			$user->password = $samebookUser['pwd'];
			$user->salt = $samebookUser['salt'];
			if($user->save()){
				$userInfo = new UserInfo;
				$userInfo->name = $samebookUser['username'];
				$userInfo->id = $user->getPrimaryKey();
				$userInfo->email = $user->email;
				$userInfo->introduction = $samebookUser['bio'];
				$userInfo->addTime = time();
				$userInfo->status = 'ok';
				$userInfo->save();
			}
		}
		$userInfo = UserInfo::model()->findByAttributes(array('email'=>$samebookUser['email']));
		//列入oauth表
		if(empty($userInfo->oauth)){
			$oauth = new Oauth;
			$oauth->userId = $user->id;
			$oauth->save();
		}
		$userInfo = UserInfo::model()->findByAttributes(array('email'=>$samebookUser['email']));
		//在oauth表中加sbid
		if(!$userInfo->oauth->sbid){
			$userInfo->oauth->sbid = $samebookUser['userId'];
			$userInfo->oauth->save();
			$userInfo = User::model()->findByAttributes(array('email'=>$samebookUser['email']));
		}
	}
	protected function loginUserWithoutPwd($email){
		//站内用户登录
		$identity=new UserIdentity($email,'somepassword');
		$identity->authenticate(true);

		if($identity->errorCode===UserIdentity::ERROR_NONE)
		{
			header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
			//$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days

			Yii::app()->user->login($identity, 0);
			//print_r(Yii::app()->user);
		}
	}
}