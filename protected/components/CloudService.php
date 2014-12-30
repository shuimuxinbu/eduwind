<?php
class CloudService extends CComponent{
	private static $_instance;
	private  $_sourceUrl;
	private  $_uploadUrl;
	private $_key;
	private $_bucket;
	private $_accessKey;
	private $_secretKey;
	private $_cloudServer;
	private $_apiServer;
	private $_uploadServer;
	public $avthumbPreset= array('low'=>'video_440k',
									'normal'=>'video_640k',
									'high'=>'video_1000k');
	
	//private

	private function __construct() {
		$cloudStorageForm = new CloudStorageForm();
		$cloudStorageForm->getSetting();
		if(isset($cloudStorageForm->bucket) && $cloudStorageForm->bucket)
			$this->_bucket = $cloudStorageForm->bucket;
		if(isset($cloudStorageForm->accessKey) && $cloudStorageForm->accessKey)
			$this->_accessKey = $cloudStorageForm->accessKey;
		if(isset($cloudStorageForm->secretKey) && $cloudStorageForm->secretKey)
			$this->_secretKey = $cloudStorageForm->secretKey;
		if(isset($cloudStorageForm->cloudServer) && $cloudStorageForm->cloudServer)
			$this->_cloudServer = $cloudStorageForm->cloudServer;
		if(isset($cloudStorageForm->apiServer) && $cloudStorageForm->apiServer)
			$this->_apiServer = $cloudStorageForm->apiServer;
		if(isset($cloudStorageForm->uploadServer) && $cloudStorageForm->uploadServer)
			$this->_uploadServer = $cloudStorageForm->uploadServer;
	}
	public static function getInstance($key="") {
		if(self::$_instance === null) {
			self::$_instance = new CloudService();
		}
		if($key){
			self::$_instance->setKey($key);
		}
		return self::$_instance;
	}

	public function setKey($key){
		$this->_key = $key;
	}
	public function getSourceUrl(){
		if($this->_apiServer) return $this->_apiServer;
		if ($this->_sourceUrl === null) {
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$this->_cloudServer.'/cloudSourceUrl');
			curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('host'=>Yii::app()->request->hostInfo));
			$data = curl_exec($ch);//运行curl
			curl_close($ch);
			$this->_sourceUrl = $data;
		}
		return $this->_sourceUrl;
	}
	
	public function getKey(){
		return $this->_key;
	}

	public function getUploadUrl() {
//		error_log(print_r($this,true));
		if ($this->_uploadUrl === null) {
			$ch = curl_init();//初始化curl
			curl_setopt($ch,CURLOPT_URL,$this->_cloudServer.'/cloudUploadUrl');//抓取指定网页
			curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 3);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('host'=>Yii::app()->request->hostInfo));
			$data = curl_exec($ch);//运行curl
			curl_close($ch);
			if(data)
				$this->_uploadUrl = $data;
			else 
				$this->_uploadUrl = $this->_uploadServer;
		}
		return $this->_uploadUrl;
	}

	public function getUploadifySetting() {

		$setting = array(
		  'name'=>'file',
		  'auto'=>true,
    	  'buttonText'=>Yii::t('app','选择文件'),
   		  'formData'=>array(	//此处插入post到服务器的数据
		    			'token'=>$this->makeUploadToken(),
    					'key'=>$this->_key,
			),
		   'onUploadStart'=>"js:function(file) {
    				$.ajax({
    					url:'".Yii::app()->createAbsoluteUrl('cloud/uploadUrl')."',
    					async:false,
    					success:function(data){
    						dataObj = JSON.parse(data);
    						$('.uploadify').uploadify('settings','uploader',dataObj.url);
    					}
    				});
		   					
		   }",
		//根据回调的结果更新表单的MediaId字段
		   'onUploadSuccess' =>"js:function(file, data, response) {
			   					dataObj = JSON.parse(data);
		//	   					$('input#mediaId').val(dataObj.id);
		//	   					$('p#uploadFileName').html('文件“' + file.name + '”已经上传成功。<a id=\"reUpload\" href=\"javaScript:void(0)\">重新上传</a>');
		//	   					$('.uploadify').uploadify('settings','buttonText','再次上传');
			   					if(data){
			  						$('#uploaded-file-$this->model->id').html('<span style=\'text-success\'>“' + file.name + '</span>”已经上传成功。');
			  					}else{
			  						$('#uploaded-file-$this->model->id').html('<span style=\'text-error\'>“' + file.name + '</span>”上传失败。');
    							}
					}",
			    'onQueueComplete'=>"js:function(queueData) {
			            $('div#file').addClass('dxd-hidden');
			        }"
		
			        );
			        return $setting;
	}

	public function getDownloadUrl($path) {
		if(DxdUtil::endWith($path, '.m3u8')){
			$url = $this->getSourceUrl().$path.'?pm3u8/0&e='.strval(3600+time());
		}else{
			$url = $this->getSourceUrl().$path.'?e='.strval(3600+time());
		}
		$url=trim($url);
		$sign = hash_hmac('sha1', $url, $this->_secretKey, true);
	//	error_log("length of sign:".strlen($sign));
		$find = array('+', '/');
		$replace = array('-', '_');
		$token = str_replace($find, $replace, base64_encode($sign));
	//	error_log("length of tocken:".strlen($token));
		return $url.'&token='.$this->_accessKey.':'.$token;
	}

	public function makeUploadToken() {
		if(self::authBucket()){
			$uploadSetting = $this->makeUploadSetting();
			return $this->_accessKey.':'.self::sign($uploadSetting).':'.($uploadSetting);
		}
	}
	
	public function authBucket(){
		
		$ch = curl_init();//初始化curl
		curl_setopt($ch,CURLOPT_URL,$this->_cloudServer.'/authBucket');
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array('bucket'=>$this->_bucket));
		$data = curl_exec($ch);//运行curl
		curl_close($ch);
		if($data == 'authorized') {
			return true;
		}
		else return false;
	}

	private function sign($data) {
		$sign = hash_hmac('sha1', $data, $this->_secretKey, true);
		$find = array('+', '/');
		$replace = array('-', '_');
		return str_replace($find, $replace, base64_encode($sign));
	}

	/**
	 * Enter description here ...
	 */
	private function makeUploadSetting() {
		$uploadSetting = array();
		$bucket = $this->_bucket;
		$uploadSetting['scope'] = $bucket;
		$encodedEntryURI = base64_encode("$bucket:$this->_key.m3u8");
		$uploadSetting['deadline'] = 3600+time();
		$uploadSetting['CallbackUrl'] = Yii::app()->createAbsoluteUrl('/cloud/uploadCallback');
		$uploadSetting['CallbackBody'] = "name=$(fname)&key=$(key)&mime=$(mimeType)&size=$(fsize)&userId=".Yii::app()->user->id;
		$uploadSetting["persistentOps"]= "avthumb/m3u8/segtime/15/preset/".$this->avthumbPreset['high']."|saveas/$encodedEntryURI";
		$uploadSetting["persistentNotifyUrl"] = Yii::app()->createAbsoluteUrl('/cloud/persistentNotify');
		$find = array('+', '/');
		$replace = array('-', '_');
		return str_replace($find, $replace, base64_encode(json_encode($uploadSetting)));
	}

    /**
     * @param $key  要删除的文件
     */
    public function deleteFile($key){
    	error_log('deleting');
    	$bucket = $this->_bucket;
    	$find = array('+', '/');
    	$replace = array('-', '_');
    	$encodedURI = str_replace($find, $replace, base64_encode("$bucket:$key"));
    	$path = '/delete/'.$encodedURI;
    	$data = $path."\n";
    	
    	$sign = $this->sign($data);
    	
    	
    	$ch = curl_init();//初始化curl
    	curl_setopt($ch,CURLOPT_URL,$this->_cloudServer.'/deleteFile');
    	curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, array('bucket'=>$this->_bucket,'accessKey'=>$this->_accessKey,'sign'=>$sign,'path'=>$path));
    	$return = curl_exec($ch);//运行curl
    	curl_close($ch);
    	//返回结果
        $result = json_decode($return);
        error_log(print_r($result,true));
        return $result;
    }

    /**
     * @param $key  要删除的m3u8文件名
     */
    public function deleteSlices($key){
        $url = $this->_apiServer.$key.'?e='.strval(600+time());
        $url=trim($url);
        $sign = $this->sign($url);
        $url = $url.'&token='.$this->_accessKey.':'.$sign;

        if(@fopen($url,"r")) {  //判断 m3u8文件是否存在
            $file_handle = fopen($url,"r");
            //解析m3u8内容
            while(!feof($file_handle)) {
                $line = fgets($file_handle);
                if(substr($line,0,1) == "#")    //注释
                    continue;
                $urlArray = parse_url($line);
                if(isset($urlArray['query'])) { //带参数情况
                    $sliceKey = substr($urlArray['path'],1);
                }else { //不带参数情况
                    $sliceKey = substr($urlArray['path'],1,-1);
                }
                //删除切片
                $this->deleteFile($sliceKey);
            }
            fclose($file_handle);
            $this->deleteFile($key);
            return true;
        }
        else
            return false;
    }

}