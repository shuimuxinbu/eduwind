<?php
/**
 * 搜索相关事宜
 * Enter description here ...
 * @author ryoukinhua
 *
 */
class RennService extends CComponent{
	public $appId;
	public $apiKey;
	public $secretKey;
	public $redirectUri;
	public $enabled = false;

	public $rennClient=null;

	function __construct(){
		
	//	if(isset(Yii::app()->params['settings']['openAuth']['rennEnabled'])){
			$this->appId = Yii::app()->params['settings']['openAuth']['rennAppId'];
			$this->apiKey = Yii::app()->params['settings']['openAuth']['rennApiKey'];
			$this->secretKey = Yii::app()->params['settings']['openAuth']['rennSecretKey'];
//			$this->redirectUri = Yii::app()->createAbsoluteUrl("//oauth/rennOauth");
	//	}
	}

	public function getClient() {
		Yii::import('ext.rennclient.RennClient');
		if(!$this->rennClient) {
			$this->rennClient = new RennClient($this->apiKey, $this->secretKey);
			$this->rennClient->setDebug($this->enabled);
		}
		return $this->rennClient;	
	}
		
}