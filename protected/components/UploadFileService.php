<?php
/**
 * 提供上传文件服务，例如上传，删除
 * 依赖于xupload ext和File model
 * @author ryoukinhua
 *
 */
class UploadFileService extends CComponent{
	private  $_uploader;
	
	/**
	 * 判断是否应该开始处理上传文件事宜
	 * Enter description here ...
	 */
	public function toStartHandle(){
		return (!empty($_FILES) || (isset($_GET["_method"]) && $_GET["_method"] == "delete"));
	}

	/**
	 * 处理文件（上传下载）事宜
	 * Enter description here ...
	 */
	public function handle(){
		$result = $this->uploader->run(array(
	                'path' =>Yii::app() -> getBasePath() . "/../uploads/file",
	                'publicPath' => Yii::app() -> getBaseUrl() . "/uploads/file",
		));
		if(!$this->isDeleting()){
			$file = new File;
			$file->name = $result['name'];
			$file->size = $result['size'];
			$file->addTime = time();
			$file->userId = Yii::app()->user->id;
			$file->path = substr($result['url'],strrpos($result['url'],'/uploads/'));
			$file->save();
//			error_log(print_r($file));
		}else{
			$file = File::model()->findByAttributes(array('path'=>substr($result['url'],strrpos($result['url'],'/uploads/'))));
			if($file) $file->delete();
		}
		return $file;
	}

	/**
	 * 判断本次处理为删除或是上传
	 * Enter description here ...
	 */
	public function isDeleting(){
		return $this->uploader->isDeleting();
	}
	/**
	 * 获得uploader
	 */
	public function getUploader(){
		if(!$this->_uploader){
			Yii::import('xupload.actions.XUploader');
			$this->_uploader= new XUploader();
		}
		return $this->_uploader;
	}
}