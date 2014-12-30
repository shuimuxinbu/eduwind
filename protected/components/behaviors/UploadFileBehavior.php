<?php

require_once "AttachmentUploadedFile.php";
class UploadFileBehavior extends CActiveRecordBehavior {

	/**
	 * @property string folder to save the attachment
	 */
	public $folder = 'uploads';
	public $cacheFolder = "caches";
	
	/**
	 * 形如 array('fileId'=>array('exts'=>array('doc','xls')),
	 			 'photoId'=>array('exts'=>array('png'))
	 			 );
	 * Enter description here ...
	 * @var unknown_type
	 */
	public $items =array();

	/**
	 * @property string path to save the attachment
	 */
	public $path = ':folder/uploadFile/:model/:attribute/:id.:ext';

	/**
	 * @property names of attribute which holds the attachment
	 */
	//	public $attributes = array('filename');

	public $attributes = array();
	//	public $filename;
	public $uploadFile;
	/**
	 * @property array of processors
	 */
	public $processors = array();

	/**
	 * @property array of styles needs to create
	 * example:
	 * array(
	 * 'small' => '150x75',
	 * 'medium' => '!250x70'
	 * )
	 */
	public $styles = array();

	/**
	 * @property string $fallback_image placeholder image src.
	 */
	public $fallback_image;

	private $file_extension, $filename;
	
	public function beforeSave($event){
		/**
		 * 强制图片只能修改，不能删除
		 */
		foreach ($this->items as $attribute=>$config){
			if(!$this->getOwner()->{$attribute}){
				unset($this->getOwner()->{$attribute});
			}
		}
	}
	/**
	 * getter method for the attachment.
	 * if you call it like a property ($model->Attachment) it will return the base size.
	 * if you have the styles specified you can get them like this:
	 * $model->getAttachment('small')
	 * @param string $style style to return
	 */
	public function getAttachment($attribute,$style = '')
	{
		if($style == ''){
			if($this->hasAttachment($attribute))
			return $this->Owner->{$attribute};
			elseif($this->fallback_image != '')
			return $this->fallback_image;
			else
			return '';
		}else{
			if(isset($this->styles[$style])){
				$im = preg_replace('/\.(.*)$/','-'.$style.'\\0',$this->Owner->{$attribute});
				if(file_exists($im))
				return $im;
				elseif(isset($this->fallback_image))
				return $this->fallback_image;
			}
		}

	}

	/**
	 * check if we have an attachment
	 */
	public function hasAttachment($attribute)
	{
		return file_exists($this->Owner->{$attribute});
	}

	/**
	 * deletes the attachment
	 */
	public function deleteAttachment($attribute)
	{
		$uploadFile = UploadFile::model()->findByPk($this->Owner->{$attribute});
		if($uploadFile) $uploadFile->delete();

	}

	/**
	 * 循环删除附件
	 * @param unknown_type $event
	 */
	public function afterDelete($event)
	{
//		foreach($this->attributes as $attribute)
		foreach($this->items as $attribute=>$config){
			$this->deleteAttachment($attribute);
		}
	}

	/**
	 * 保存一个附件
	 * @param unknown_type $attribute
	 * @throws CException
	 */
	public function saveAttachment($attribute){
		$file = AttachmentUploadedFile::getInstance($this->Owner,$attribute);
		if(!is_null($file)){
//			if(!$this->Owner->isNewRecord){
				//delete previous attachment
				//			if(file_exists($this->Owner->{$attribute})){
				$this->Owner->refresh();
				$uploadFile = UploadFile::model()->findByPk($this->Owner->{$attribute});
				if($uploadFile) $uploadFile->delete();
				$this->Owner->isNewRecord = false;
				//unlink($this->Owner->{$attribute});
				//		}
//			}else{
//				$this->Owner->isNewRecord = false;
//			}
			preg_match('/\.(.*)$/',$file->name,$matches);
			$this->file_extension = end($matches);
			//检查后缀名是否符合
			if(!empty($this->items[$attribute]['exts']) && 
			   !in_array($this->file_extension,$this->items[$attribute]['exts'])) 
				return false; 
			
			$this->filename = $file->name;
			$path = $this->getParsedPath($attribute);

			preg_match('|^(.*[\\\/])|', $path, $match);
			$folder = end($match);
			if(!is_dir($folder))mkdir($folder, 0777, true);

			$file->saveAs($path,false);
			$file_type = filetype($path);
			$uploadFile = new UploadFile();
			$uploadFile->userId = Yii::app()->user->id;
			$uploadFile->addTime = time();
			$uploadFile->name = $file->name;
			//$uploadFile->mime  = mime_content_type($path);
			$uploadFile->mime = CFileHelper::getMimeType($path) ?  CFileHelper::getMimeType($path)  :"";
			$uploadFile->type = $this->file_extension;
			$uploadFile->size = filesize($path);
			$uploadFile->path = $path;
			$uploadFile->save();

			$this->Owner->saveAttributes(array($attribute => $uploadFile->id));

		}
		return true;
	}
	/**
	 * 循环保存多个附件
	 * @param unknown_type $event
	 */
	public function afterSave($event)
	{
		//foreach($this->attributes as $attribute){
		foreach($this->items as $attribute=>$config){	
			$this->saveAttachment($attribute);
		}
		return true;
	}

	public function getParsedPath($attribute="filename",$custom = '')
	{
		$needle = array(':folder', ':model', ':id', ':ext', ':filename', ':custom',':attribute');
		$replacement = array($this->folder, lcfirst(get_class($this->Owner)), $this->Owner->primaryKey,$this->file_extension, $this->filename, $custom,$attribute);
		if(preg_match_all('/:\\{([^\\}]+)\\}/', $this->path, $matches, PREG_SET_ORDER)) {
			foreach($matches as $match) {
				$valuePath = explode('.', $match[1]);
				$value = $this->owner;
				foreach($valuePath as $attributeName) {
					if(is_object($value))
					$value = $value->{$attributeName};
				}
				$needle[] = $match[0];
				$replacement[] = $value;
			}
		}
		return str_replace($needle, $replacement, $this->path);
	}


	public function UnsafeAttribute($name, $value)
	{
		//	var_dump(true);exit;
		//	if($name != $attribute)
		parent::onUnsafeAttribute($name, $value);
	}
}