<?php
/**
 * 搜索相关事宜
 * Enter description here ...
 * @author ryoukinhua
 *
 */
class UpgradeService extends CComponent{
	private $_serverUrl;
	public $defaultServerUrl = 'http://www.eduwind.com/index.php?r=';
	//static $serverUrl = 'http://localhost/eduhome/index.php?r=';
	public $checkUpgradeUrl = 'upgradeServer/checkUpgrade';
	public $downloadUrl = 'upgradeServer/download';
	public $downloadPath = "/caches";
	public $getMd5Url = "upgradeServer/getMd5";

	public function getServerUrl(){
		if(!$this->_serverUrl) {
			$upgradeForm = new UpgradeForm();
			$upgradeForm->getSetting();
			if(isset($upgradeForm->serverUrl) && $upgradeForm->serverUrl)
				$this->_serverUrl = $upgradeForm->serverUrl;
			else 
				$this->_serverUrl = $this->defaultServerUrl;
		}
		return $this->_serverUrl;
	}
	
	public static function getService(){
		return new UpgradeService();
	}
	
	/**
	 * 检查更新包信息，把新的信息插入到upgradeInfo表中
	 * Enter description here ...
	 */
	public function checkUpgradeServer() {
		$siteForm = new SiteForm();
		$siteForm->getSetting();
		#取出最大的versionId
		$currentVersion =$siteForm->version;

		//$latestVersionId = self::getLatestVersionId();
		#将最大的versionId传回到server去，查看有无新的更新包
		$arrPostInfo = array("currentVersion"=>$currentVersion,"baseUrl"=>Yii::app()->createAbsoluteUrl("/"));
		$url = $this->serverUrl.$this->checkUpgradeUrl;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $arrPostInfo);
		curl_setopt($ch,CURLOPT_TIMEOUT,3);
		$response = curl_exec($ch);
		curl_close($ch);
		#将返回的更新包信息写入数据库中
		self::updateUpgradeInfo($response);
	}

	/**
	 * 覆盖代码，执行脚本
	 * 下载的代码位于caches/upgradepackage_$version/upgrade/eduwind
	 * 需要替换网站根目录
	 * Enter description here ...
	 * @param unknown_type $version
	 */
	public  function upgradeImplement($version) {
		
		$src = dirname(Yii::app()->basePath).$this->downloadPath."/upgradepackage_".$version."/upgrade/eduwind";
		$dst = dirname(Yii::app()->basePath);
		
		try {
			#检测有无脚本
			if (file_exists('caches/upgradepackage_'.$version.'/upgrade/upgrade.php')) {
				require_once 'caches/upgradepackage_'.$version.'/upgrade/upgrade.php';
				EduwindUpgrade::upgrade();
			}
			self::overridecopy($src,$dst);
			#删除更新包
			unlink(dirname(Yii::app()->basePath).$this->downloadPath."/upgradepackage_".$version.".zip");
			self::rrmdir(dirname(Yii::app()->basePath).$this->downloadPath."/upgradepackage_".$version);
			#对数据库进行更新
			$model = UpgradeInfo::model()->findByAttributes(array('version'=>$version));
			$model->status = 'installed';
			$model->save();
			$message = '更新代码替换成功！';
			$siteForm = new SiteForm();
			$siteForm->getSetting();
			$siteForm->version = $model->version;
			$result = $siteForm->saveSetting();
			error_log(print_r($result,true));
			$status = 'success';
		} catch (Exception $e) {
			$message = '更新失败，信息信息：'.$e->getMessage();
			$status = 'failed';
		}
		

		$message = '<div id="upgradeMsg" class="upgrade_'.$status.'">'.$message.'</div>';
		return array('message'=>$message,'status'=>$status);
	}

	/**
	 * 下载更新包zip(下载到caches/upgradepackage_$version.zip)
	 * Enter description here ...
	 * @param $version
	 */
	public function downloadUpgradePackage($version) {
		
		$arrPostInfo = array("version"=>$version,"baseUrl"=>Yii::app()->createAbsoluteUrl("/"));
		$url = $this->serverUrl.$this->downloadUrl;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $arrPostInfo);
		$response = curl_exec($ch);
		curl_close($ch);
		$zipfile_path = "caches/upgradepackage_".$version.".zip";
		if(file_put_contents($zipfile_path, $response)){
			//再次发起一个查询，询问更新包的md5
			$arrPostInfo = array("version"=>$version);
			$url = $this->serverUrl.$this->getMd5Url;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $arrPostInfo);
			$serverMd5 = curl_exec($ch);
			curl_close($ch);
			
			$localMd5 = md5_file($zipfile_path);
			
			if ($serverMd5 == $localMd5) {
				$message = '下载成功，文件保存在：'.$zipfile_path;
				$status = 'success';
			}
			else {
				$message = $serverMd5.'----'.$localMd5;
				$status = 'failed';
			}
		}else {

			$message = '下载失败,停止更新';
			$status = 'failed';
		}
		$message = '<div id="upgradeMsg" class="upgrade_'.$status.'">'.$message.'</div>';
		return array('message'=>$message,'status'=>$status);
	}
	/**
	 * 解压更新包 解压到 caches/upgradepackage_$version下
	 * Enter description here ...
	 * @param unknown_type $version
	 */
	public static function extractUpgradePackage($version) {
		$zip = new ZipArchive();
		$zipfile_path ="caches/upgradepackage_".$version.".zip";
		$message = '解压失败,停止更新';
		$status = 'failed';
		if ($zip->open($zipfile_path) == true) {
			$extractPath = "caches/upgradepackage_".$version;
			if($zip->extractTo($extractPath)){
				$message = '解压成功，文件解压在：'.$extractPath;
				$status = 'success';
			}
			$zip->close();
		}
		$message = '<div id="upgradeMsg" class="upgrade_'.$status.'">'.$message.'</div>';
		return array('message'=>$message,'status'=>$status);
	}
	
		/**
	 * 用来更新upgradeinfo信息
	 * Enter description here ...
	 * @param json $response 从服务器得到的需要更新的更新包信息 
	 */
		public static function updateUpgradeInfo($response) {
		$result = json_decode($response,true);
		$siteInfo = new SiteForm();
		$siteInfo->getSetting();
		if (count($result)) {
			//对每一个需要更新的包
			foreach($result as $r) {
				$model=new UpgradeInfo;
				$model->versionId = $r['id'];
				if(UpgradeInfo::model()->findByAttributes(array('versionId'=>$r['id']))) continue;
				$model->version = $r['version'];
				$model->name = $r['name'];
				$model->addTime = $r['addTime'];
				$model->description = $r['description'];
				if(UpgradeInfo::compareVersion($siteInfo->version,$model->version)<0)
					$model->save();
			}
		}
	}
	

	
	
	private static function overridecopy($src,$dst) {
	    $dir = opendir($src);
	    if(!is_dir($dst))
	    	mkdir($dst,0777);
	    while(false !== ( $file = readdir($dir)) ) {
	        if (( $file != '.' ) && ( $file != '..' )) {
	            if ( is_dir($src . '/' . $file) ) {
	                self::overridecopy($src . '/' . $file,$dst . '/' . $file);
	            }
	            else {
	                if(file_exists($dst . '/' . $file))
	                	unlink($dst . '/' . $file);
	                copy($src . '/' . $file,$dst . '/' . $file);
	            }
	        }
	    }
	    closedir($dir);
	}
	
	private static function rrmdir($dir) {
		
		if(is_dir($dir)) {
			$files = scandir($dir);
			foreach ($files as $file)
				if ($file != '.' && $file != "..") self::rrmdir("$dir/$file");
			rmdir($dir);		
		}
		else if (file_exists($dir)) unlink($dir);
	}
}