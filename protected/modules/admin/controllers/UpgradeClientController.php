<?php

class UpgradeClientController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin/nonav_column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
			'rights',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	*/

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		UpgradeService::getService()->checkUpgradeServer();
		$siteInfo = new SiteForm();
		$siteInfo->getSetting();
		$dataProvider=new CActiveDataProvider('UpgradeInfo',array(
			'criteria'=>array('order'=>'versionId DESC'),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'siteInfo'=>$siteInfo,
		));
	}

	public function actionDoUpgrade() {
		$siteInfo = new SiteForm();
		$siteInfo->getSetting();

		if(UpgradeInfo::compareVersion($siteInfo->version, "1.3.0")<0){
			$siteInfo->version = "1.3.0";
			$siteInfo->saveSetting();
		}

		$criteria = new CDbCriteria;
		//$criteria->select = 'version';
		$criteria->condition = 'status=:status';
		$criteria->order = 'versionId';
		$criteria->params = array(':status'=>'not installed');
		$upgradeInfos = UpgradeInfo::model()->findAll($criteria);
		$vertionString = '';
		foreach ($upgradeInfos as $upgradeInfo) {
			if(UpgradeInfo::compareVersion($siteInfo->version, $upgradeInfo->version)>=0){
				$upgradeInfo->status ="skipped";
				$upgradeInfo->save();
				continue;
			}
			$vertionString .= '"'.strval($upgradeInfo->version).'",';
		}
		$this->layout = "/layouts/nonav_column1";
		$this->render('do_upgrade_fancy',array('versions'=>$vertionString,));
	}

	public function actionCheckEnv() {
		$arrResult = array();
		$this->checkEnvWritable($arrResult);
		$status = 'success';
		$message = '<p>必要目录都可写，检查通过！</p>';
		if ($arrResult != array()) {
			$status = 'failed';
			$message = '<p>环境检查失败！存在以下问题：</p>';
			foreach ($arrResult as $result) {
				$message .= '<p>'.$result.'</p>';
			}
		}
		$message = '<div id="upgradeMsg" class="upgrade_'.$status.'">'.$message.'</div>';
		echo json_encode(array('status'=>$status,'message'=>$message));
	}

	private function checkEnvWritable(&$arrResult){
		//整个网站的根目录
		$root = dirname(Yii::app() -> getBasePath());
		$this->checkSelfWritable($root,$arrResult);
		//检查目录是否可写
		$subDirs = array('/caches','/css','/images','/js');
		foreach ($subDirs as $Dir) {
	    	$this->checkSelfWritable($root.$Dir,$arrResult);
		}
		//检查目录及所有子目录是否可写
		$this->checkEntireDirWritable($root.'/protected',$arrResult);
		$this->checkEntireDirWritable($root.'/themes',$arrResult);
	}

	private function checkSelfWritable($path,&$arrResult) {
		if (!is_writable($path)) {
	    	$arrResult[] = "目录：".$path." 不可写。";
	    }
	    //else $arrResult[] = "目录：".$path." 可写。";
	}

	private function checkEntireDirWritable($path,&$arrResult) {
		//检查路径是否可以写，并记录下来
	    $dir = opendir($path);
	    $this->checkSelfWritable($path,$arrResult);
	    while(false !== ( $file = readdir($dir)) ) {
	        if (( $file != '.' ) && ( $file != '..' )) {
	        	//如果是子文件夹
	            if ( is_dir($path . '/' . $file) ) {
	                $this->checkEntireDirWritable($path . '/' . $file, $arrResult);
	            }
	        }
	    }
	    closedir($dir);
	}

	public function actionDownloadPackage() {

		$version = $_POST['version'];
		$arrResult = UpgradeService::getService()->downloadUpgradePackage($version);
		echo json_encode($arrResult);
	}

	public function actionExtractPackage() {
		$version = $_POST['version'];
		$arrResult = UpgradeService::getService()->extractUpgradePackage($version);
		echo json_encode($arrResult);
	}

	public function actionUpgradeImplement() {
		$version = $_POST['version'];
		$arrResult =UpgradeService::getService()->upgradeImplement($version);
		echo json_encode($arrResult);
	}



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=UpgradeInfo::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='upgrade-info-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
