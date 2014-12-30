<?php
/**
*@author lonestone
*/
class UcenterApplication extends CWebApplication{
	public $ucController = 'uc';
	
	private $route = '';
	
	protected function preinit()
	{
		$this->parseRequest();
	}
	
	private function parseRequest()
	{
		$_DCACHE = $get = $post = array();

		$code = @$_GET['code'];
		parse_str($this->_authcode($code, 'DECODE', UC_KEY), $get);
		if(MAGIC_QUOTES_GPC) {
			$get = $this->_stripslashes($get);
		}
		
		$timestamp = time();
		if($timestamp - $get['time'] > 3600) {
			exit('Authracation has expiried');
		}
//		error_log("get".print_r($get,true));
		if(empty($get)) {
			exit('Invalid Request');
		}
		$action = $get['action'];
		require_once DISCUZ_ROOT.'./uc_client/lib/xml.class.php';
		$post = xml_unserialize(file_get_contents('php://input'));
		Yii::log($get, 'debug');
		Yii::log($post, 'debug');
		$_GET = $get;
		$_POST = $post;
		
		$this->route = $this->ucController .'/'. $action;
		error_log("route".$this->route);
		if(!in_array($action, array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcreditsettings', 'updatecreditsettings'))) 
		{
			exit(API_RETURN_FAILED);
		}
	}

	public function processRequest()
	{
		$this->runController($this->route);
	}
	
	private function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		$ckey_length = 4;

		$key = md5($key ? $key : UC_KEY);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);

		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);

		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}

	}

	private function _stripslashes($string) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = $this->_stripslashes($val);
			}
		} else {
			$string = stripslashes($string);
		}
		return $string;
	}
}
