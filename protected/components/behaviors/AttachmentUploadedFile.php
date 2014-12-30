<?php


class AttachmentUploadedFile
{
	public $name, $_error ;

	public static function getInstance($model, $attribute){
		$c = new AttachmentUploadedFile;
		$c->modelName = get_class($model);
		if(empty($_FILES[$c->modelName]) || empty($_FILES[$c->modelName]['name'][$attribute]))return null;
		$c->name = $_FILES[$c->modelName]['name'][$attribute];
		$c->file_name = $_FILES[$c->modelName]['tmp_name'][$attribute];
		if(!file_exists($c->file_name))return null;
		return $c;
	}

	public function saveAs($file){
		if($this->_error==UPLOAD_ERR_OK){
			if(is_uploaded_file($this->file_name)){
				return move_uploaded_file($this->file_name, $file);
			}else{
				return rename($this->file_name, $file);
			}
		}else return false;
	}
}