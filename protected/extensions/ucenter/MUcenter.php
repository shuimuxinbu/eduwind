<?php

$ucenterPath = Yii::app()->basePath."/../partner/ucenter";

require_once ($ucenterPath.'/config.inc.php');
require_once($ucenterPath.'/uc_client/client.php');

class MUcenter{
	var $_path;

	public function saveConfig($content){
	//	$index = file_get_contents(dirname(__FILE__)."/ucenter_index.php");
		$file = $this->getPath().'/config.inc.php';
		$result =file_put_contents($file,"<?php \n  $content  ");
		return $result;
	}	
	
	function getPath(){
		if(!$this->_path){
			$this->_path = Yii::app()->basePath."/../partner/ucenter";
		}
		return $this->_path;
	}
}