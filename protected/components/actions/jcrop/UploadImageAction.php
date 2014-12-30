<?php
class UploadImageAction extends CAction{
	public $modelName;
	public $attribute;
	public $uploadViewFile = "upload_face";
	public $cropViewFile = "crop_face";
	public $id;

	/**
	 * 关注或取消关注
	 * @param unknown_type $id
	 */
	public function run(){
		if(!$this->id) $this->id = $_GET['id'];
		$id=$this->id;
		$model =$this->controller->loadModel($id);
		if(!$this->modelName)
			$this->modelName = get_class($model);
		if(isset($_POST[$this->modelName])){
			$model->attributes = $_POST[$this->modelName];
			if($model->save()){
				$this->controller->redirect(array('cropFace','id'=>$id));
			}else{
				Yii::app()->user->setFlash('error','上传失败！');
			}
		}
		$this->controller->render($this->uploadViewFile,array('model'=>$model));
	}
}