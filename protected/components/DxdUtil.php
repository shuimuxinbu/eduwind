<?php
/**
 * 大西岛的辅助工具
 * @author liang
 *
 */
class DxdUtil{
	/**
	 * 创建文件目录，如果父目录不存在，同时创建父目录
	 * @param unknown_type $path
	 */
	public static function createFolders($path)  {
		//递归创建
		if (!file_exists($path)){
			DxdUtil::createFolders(dirname($path));//取得最后一个文件夹的全路径返回开始的地方
			mkdir($path, 0777);
		}
	}

	/**
	 * 获取文件的扩展名
	 * @param unknown_type $fileName
	 */
	public static function fileExt($fileName){
		$name=explode(".",$fileName);
		$ext = end($name);
		return $ext;
	}
	/**
	 +----------------------------------------------------------
	 * 生成随机字符串
	 +----------------------------------------------------------
	 * @param int       $length  要生成的随机字符串长度
	 * @param string    $type    随机码类型：0，数字+大小写字母；1，数字；2，小写字母；3，大写字母；4，特殊字符；-1，数字+大小写字母+特殊字符
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	public static function randCode($length = 5, $type = 0) {
		$code = "";
		$arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 4 => "~@#$%^&*(){}[]|");
		if ($type == 0) {
			array_pop($arr);
			$string = implode("", $arr);
		} else if ($type == "-1") {
			$string = implode("", $arr);
		} else {
			$string = $arr[$type];
		}
		$count = strlen($string) - 1;
		for ($i = 0; $i < $length; $i++) {
			$str[$i] = $string[mt_rand(0, $count)];
			$code .= $str[$i];
		}
		return $code;
	}


	/**
	 * 发送邮件
	 * @param unknown_type $sendmail
	 * @param unknown_type $subject
	 * @param unknown_type $content
	 * @param unknown_type $replyto
	 * @param unknown_type $fromname
	 * @param unknown_type $fromaddr
	 */
	public static function postMail($sendmail,$subject,$content,$replyto="",$fromname="",$fromaddr=""){

		global $sysSettings;
		if(!$replyto) $replyto = $sysSettings['mailer']['username'];
		$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
		$mailer->Host = $sysSettings['mailer']['host'];
		//	var_dump($mailer->Host);
		//	  $mailer->SMTPDebug = 1;
		$mailer->IsSMTP();
		$mailer->SMTPAuth = true;
		$mailer->From = $sysSettings['mailer']['username'];

		//	$mailer->From = $fromaddr;
		$mailer->AddReplyTo($replyto);
		$mailer->AddAddress($sendmail);
		$mailer->Username = $sysSettings['mailer']['username'];
		$mailer->Password = $sysSettings['mailer']['password'];
		$mailer->FromName = $sysSettings['site']['name'];
		$mailer->CharSet = 'UTF-8';
		$mailer->Subject = $subject;
		$mailer->Body = $content;
		$mailer->IsHTML();
		return $mailer->Send();
	}

	public static function getRelativePath($from, $to)
	{
		// some compatibility fixes for Windows paths
		$from = is_dir($from) ? rtrim($from, '\/') . '/' : $from;
		$to   = is_dir($to)   ? rtrim($to, '\/') . '/'   : $to;
		$from = str_replace('\\', '/', $from);
		$to   = str_replace('\\', '/', $to);

		$from     = explode('/', $from);
		$to       = explode('/', $to);
		$relPath  = $to;

		foreach($from as $depth => $dir) {
			// find first non-matching dir
			if($dir === $to[$depth]) {
				// ignore this directory
				array_shift($relPath);
			} else {
				// get number of remaining dirs to $from
				$remaining = count($from) - $depth;
				if($remaining > 1) {
					// add traversals up to first matching dir
					$padLength = (count($relPath) + $remaining - 1) * -1;
					$relPath = array_pad($relPath, $padLength, '..');
					break;
				} else {
					$relPath[0] = './' . $relPath[0];
				}
			}
		}
		return implode('/', $relPath);
	}

	public static function generalYoukuSrc($url){
		$partern1 = "/sid\/(.+)\/v.swf/si";
		$partern2 = "/v\.youku\.com\/v_show\/id_(.+)\.html/si";
		if(preg_match($partern1, $url,$matches)){
			$src = "http://player.youku.com/embed/".$matches[1];
		} else if(preg_match($partern2, $url,$matches)){
			$src = "http://player.youku.com/embed/".$matches[1];
		}else{
			$src = $url;
		}
		return $src;
	}

	/**
	 * 按比例产生缩略图
	 * @param unknown_type $fileName 相对于Yii::app()->uploads
	 * @param unknown_type $width
	 * @param unknown_type $height
	 */
	public static function xImage($fileName,$width,$height){
		//文件是否存在
		$sourceFile = Yii::app()->basePath."/../".$fileName;

		if(!file_exists($sourceFile))
		return false;
		$ext = DxdUtil::fileExt($fileName);

		if(!in_array(strtolower($ext), array('jpg','png','jpeg')))
		return false;
			
		//新文件名，形如 filename_120_100.jpg
		$newFileName = substr($fileName, 0,strrpos($fileName,"."))."_".$width."_".$height.".".$ext;
		$targetFile = Yii::app()->basePath."/../caches/".$newFileName;

		//文件是否已经被缩略过
		if(file_exists($targetFile))
		return "caches/".$newFileName;
		//开始压缩
		Yii::import('application.extensions.EWideImage.EWideImage');
		$dir = dirname($targetFile);
		if(!file_exists($dir)){
			DxdUtil::createFolders($dir);
		}
		try{
			EWideImage::load(Yii::app()->basePath."/../".$fileName)->resize($width,$height)->saveToFile($targetFile);
		}catch (Exception $e) {
			return false;
		}
		return "caches/".$newFileName;
	}
	/**
	 * 找出某一图片文件对应的所有缓存文件
	 * Enter description here ...
	 * @param unknown_type $fileName
	 */
	public static function clearCaches($fileName){
		if($fileName){
			$ext = DxdUtil::fileExt($fileName);
			$pattern = substr($fileName, 0,strrpos($fileName,"."))."_*.".$ext;
			$pattern = Yii::app()->basePath."/../caches/".$pattern;
			$cacheFiles = glob($pattern);
			foreach($cacheFiles as $file){
				if(file_exists($file)) unlink($file);
			}
		}
	}

	public static function sendCloudMail($params){
		
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_URL, 'https://sendcloud.sohu.com/webapi/mail.send.json');
			curl_setopt($ch, CURLOPT_POSTFIELDS,$params);        

			$result = curl_exec($ch);

			if($result === false) //请求失败
			{
				echo 'last error : ' . curl_error($ch);
			}

			curl_close($ch);

			return json_decode($result);
		
	}

	//检测目录是否可写1可写，0不可写
	public static function isWriteable($file){
		if(is_dir($file)){
			$dir=$file;
			if($fp = @fopen("$dir/test.txt", 'w')) {
				fclose($fp);
				unlink("$dir/test.txt");
				$writeable = 1;
			} else {
				$writeable = 0;
			}
		}else{
			if($fp = @fopen($file, 'a+')) {
				fclose($fp);
				$writeable = 1;
			}else {
				$writeable = 0;
			}
		}
		return $writeable;

	}

	/**
	 * 返回星期的中文表示
	 * Enter description here ...
	 * @param unknown_type $w
	 */
	public static function getWeek($time){
		$w = date('w',$time);
		$arr=array("日","一","二","三","四","五","六");
		return $arr[($w%7)];
	}
	/**
	 * 根据文件扩展名取得对应的icon路径
	 * Enter description here ...
	 * @param unknown_type $ext
	 */
	public static function getIconByExt($filename){
		$path = "/images/fileicon/";
		$ext2Icon = array(  'doc'=>$path."word.png",
							'docx'=>$path."word.png",
							'xls'=>$path."excel.png",
							'xlsx'=>$path."excel.png",
							'jpg'=>$path."img.png",
							'png'=>$path."img.png",
							'gif'=>$path."img.png",
							'jpeg'=>$path."img.png",
							'ppt'=>$path."ppt.png",
							'pptx'=>$path."ppt.png",
							'txt'=>$path."txt.png",
							'zip'=>$path."rar.png",
							'rar'=>$path."rar.png",
							'mp3'=>$path."music.png",
							'pdf'=>$path."pdf.png",
							'default'=>$path."apple.png",
		);
		$ext = CFileHelper::getExtension($filename);
		return isset($ext2Icon[$ext]) ? $ext2Icon[$ext] : $ext2Icon['default'];
	}

	public static 	function return_bytes($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			// 自 PHP 5.1.0 起可以使用修饰符 'G'
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}

		return $val;
	}

	public static function startWith($haystack, $needle)
	{
		return $needle === "" || strpos($haystack, $needle) === 0;
	}
	public static function endWith($haystack, $needle)
	{
		return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
	}


	public static function num2Alpha($num,$case="uppper"){
		if($num>0&& $num<26){
			$alphas = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
			return $alphas[$num-1];
		}
		return false;
	}

	public static function duration2Day($time){
		if($r = $time/60/60/24/30/12 >= 1)
		return $r.'年前';
		elseif($r = round($time/60/60/24/30) >= 1)
		return $r.'月前';
		elseif($r = round($time/60/60/24) >= 1)
		return $r.'天前';
		elseif($r = round($time/60/60) >= 1)
		return $r.'小时前';
		elseif($r = round($time/60) >= 1)
		return $r.'分钟前';
		else
		return $time.'秒前';
	}

	public static function postCloudMail($from,$to,$subject,$content){

	}

	public static function array_remove(&$array,$value) {
		foreach($array as $i=>$item){
			if($item==$value)
			array_splice($array, $i, 1);
		}
	}
}
