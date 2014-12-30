<?php

class InstallController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/install_layout';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
		array('allow',  // allow all users to perform 'index' and 'view' actions
					'actions'=>array('index','init','env','database'),
					'expression'=>array($this,'notInstalledYet'),
		),
		array('allow',
				 'actions'=>array('finish'),
				 'users'=>array('*')),
		array('deny',
				 'users'=>array('*')),

		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex()
	{
		$this->render('index');
	}


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionEnv()
	{

		$privates = array();
		$privates['cache'] =  DxdUtil::isWriteable(Yii::app()->basePath."/../caches");
		$privates['upload'] =  DxdUtil::isWriteable(Yii::app()->basePath."/../uploads");
		$privates['asset'] =  DxdUtil::isWriteable(Yii::app()->basePath."/../assets");
		$privates['protected'] =  DxdUtil::isWriteable(Yii::app()->basePath."/../protected");
		$privates['theme'] =  DxdUtil::isWriteable(Yii::app()->basePath."/../themes");
		$privates['css'] =  DxdUtil::isWriteable(Yii::app()->basePath."/../css");
		$privates['js'] =  DxdUtil::isWriteable(Yii::app()->basePath."/../js");

		$exts = array();
		$exts['curl'] = function_exists('curl_init');
		$exts['gd'] = function_exists('gd_info');
		$exts['pdo_mysql'] = extension_loaded('pdo_mysql');
		$exts['mysqli'] = extension_loaded('mysqli');
		$exts['dom'] = extension_loaded('dom');
		
		$phpVersion = (substr(PHP_VERSION,0,3) >= 5.2);

		$maxFileSize = floor(min(DxdUtil::return_bytes(ini_get('post_max_size')),
		DxdUtil::return_bytes(ini_get('upload_max_filesize')),
		DxdUtil::return_bytes(ini_get('memory_limit')))/1024/1024);

		$pass = true;
		foreach($exts as $ext){
			if(!$ext) $pass=false;
		}
		foreach ($privates as $item){
			if(!$item) $pass=false;
		}
		if(!$phpVersion) $pass=false;
		if($maxFileSize<2) $pass=false;
			
		$this->render('env',array('privates'=>$privates,
								'exts'=>$exts,
								'pass'=>$pass,
								'phpVersion'=>$phpVersion,
								'maxFileSize'=>$maxFileSize,
		));
	}

	public function actionDatabase(){
		$model = new InstallDbForm();
		if(isset($_POST['InstallDbForm'])){
			$model->attributes = $_POST['InstallDbForm'];
			$con=mysqli_connect($model->host,$model->dbUser,$model->dbPassword);
			mysqli_set_charset($con,"utf8");
			$sql = mysqli_query($con,'show databases;');
			while($row = mysqli_fetch_assoc($sql)){
				$dbNames[] = $row['Database'];
			}
			$dbExist = in_array(strtolower($model->dbName), $dbNames) ? true :false;

			if($model->create){
				if($dbExist){
					$sql="drop DATABASE $model->dbName";
					mysqli_query($con,$sql);
				}
				$sql="CREATE DATABASE $model->dbName default charset=utf8";
				if(mysqli_query($con,$sql)){
					Yii::app()->user->setFlash('success',Yii::t('app','数据库创建成功！'));
				}
			}
			/*			if(!$dbExist && $model->create){
			 $sql="CREATE DATABASE $model->dbName default charset=utf8";
			 if(mysqli_query($con,$sql)){
			 Yii::app()->user->setFlash('success','数据库创建成功！');
			 }
			 }*/

			$con=@mysqli_connect($model->host,$model->dbUser,$model->dbPassword,$model->dbName);
			// Check connection
			if (mysqli_connect_errno())
			{
				Yii::app()->user->setFlash('error',Yii::t('app','不能连接到数据库！'));
			}else{
				$connection = new CDbConnection("mysql:host=$model->host;dbname=$model->dbName",$model->dbUser,$model->dbPassword);

				$connection->active = true;
				$sql = file_get_contents(Yii::app()->basePath."/data/install.sql");

				//				$command = $connection->createCommand($sql);

				//				$command->execute();
				$array_sql = preg_split ( "/;[\r\n]/", $sql );

				foreach ( $array_sql as $sql ) {
					$sql = trim ( $sql );
					if(strstr($sql, "--")===0) continue;
					if ($sql) {
						if (strstr ( $sql, 'CREATE TABLE' )) {
							preg_match ( '/CREATE TABLE ([^ ]*)/', $sql, $matches );
							$command = $connection->createCommand($sql);
							$command->execute();

						} else if(strpos($sql,"LOCK TABLES")===false && strpos($sql,"UNLOCK TABLES")===false ) {
							$command = $connection->createCommand($sql);
							$command->execute();

						}
						//if(!$command->execute())echo $sql;
					}
				}
					
				$db =  array(
						'connectionString' => "mysql:host=$model->host;dbname=$model->dbName",
						'emulatePrepare' => true,
						'username' => $model->dbUser,
					    'charset' => 'utf8',
						'tablePrefix'=>'ew_',
						'password' => $model->dbPassword);
				if(file_put_contents(Yii::app()->basePath."/data/db.php",'<?php  return '.var_export($db,true).";")){
					$this->redirect(array('init'));
				}else{
					Yii::app()->user->setFlash('error',Yii::t('app','数据库表创建失败!'));
				}

			}
		}
		$this->render('database',array('model'=>$model));
	}


	public function actionInit(){
		$model= new InstallInfoForm();
		$mailer = new MailerForm();
		if(isset($_POST['InstallInfoForm']) && isset($_POST['MailerForm'])){
			$model->attributes = $_POST['InstallInfoForm'];
			$siteForm = new SiteForm();
			$siteForm->name = $model->name;
			$siteForm->subTitle = $model->subTitle;
			$siteForm->saveSetting();

			$user = new User();
			$user->email = $model->adminEmail;
			$user->setPlainPassword($model->adminPassword);
			$user->save();

			$userInfo = new UserInfo();
			$userInfo->name = $model->adminName;
			$userInfo->id = $user->getPrimaryKey();
			$userInfo->email = $user->email;
			$userInfo->bio = $model->adminBio;
			$userInfo->isAdmin = 1;
			//			$userInfo->roles = "superAdmin,admin,teacher";
			$userInfo->status="ok";
			$userInfo->addTime=time();
			$userInfo->introduction = "admin";
			$mailer->attributes = $_POST['MailerForm'];

			if($userInfo->save() && $mailer->saveSetting()){
				$auth = Yii::app()->authManager;
				$auth->createRole('admin');
				$auth->createRole('teacher');
				$userInfo->roles = array('admin','teacher');
					
				$this->setNav();
				$this->setCarousel();

				Yii::app()->user->setFlash('success',Yii::t('app','系统初始化成功!'));
				$this->redirect(array('finish'));
			}

		}
		$this->render('init',array('model'=>$model,'mailer'=>$mailer));
	}

	public function actionFinish(){
		$this->render('finish');
	}


	public function setCarousel(){
		$carousel = new Carousel();
		$carousel->id = 5;
		$carousel->addTime = time();
		$carousel->path = "uploads/carousel/path/5.jpg";
		$carousel->url="";
		$carousel->weight= 0;
		$carousel->courseId = 0;
		$carousel->save();
		
		$carousel = new Carousel();
		$carousel->id = 6;
		$carousel->addTime = time();
		$carousel->path = "uploads/carousel/path/6.jpg";
		$carousel->url="";
		$carousel->weight= 1;
		$carousel->courseId = 0;
		$carousel->save();
				
	}

	public function setNav(){
		$nav = new Nav();
		$nav->title = Yii::t('app',"首页");
		$nav->activeRule = 'return Yii::app()->controller->activeMenu=="site";';
		$nav->url="/";
		$nav->save();


		$nav = new Nav();
		$nav->title = Yii::t('app',"课程");
		$nav->activeRule = 'return Yii::app()->controller->activeMenu=="course";';
		$nav->url="/course";
		$nav->save();

		$nav = new Nav();
		$nav->title = Yii::t('app',"小组");
		$nav->activeRule = 'return Yii::app()->controller->activeMenu=="group";';
		$nav->url="/group";
		$nav->save();

		$nav = new Nav();
		$nav->title = Yii::t('app',"资讯");
		$nav->activeRule = 'return Yii::app()->controller->activeMenu=="article";';
		$nav->url="/cms/article";
		$nav->save();

		$nav = new Nav();
		$nav->title = Yii::t('app',"师资");
		$nav->activeRule = 'return Yii::app()->controller->activeMenu=="people";';
		$nav->url="/cms/people";
		$nav->save();
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Answer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Answer::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Answer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='answer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * 检查权限
	 */
	public function notInstalledYet(){
		global $sysSettings;
		if(isset($sysSettings['site']['install']) && !$sysSettings['site']['install']){
			return false;
		}
		else{
			return true;
		}
	}
}
