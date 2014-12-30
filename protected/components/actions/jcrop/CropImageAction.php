<?php
class CropImageAction extends CAction{
	public $modelName;
	public $attribute="face";
	public $uploadViewFile = "upload_face";
	public $cropViewFile = "crop_face";
	public $returnUrl = "/";

	/**
	 * 关注或取消关注
	 * @param unknown_type $id
	 */
	public function run($id){
		$model = $this->controller->loadModel($id);
		if(isset($_POST['imageId_x'])){
			Yii::import('ext.jcrop.EJCropper');
			$jcropper = new EJCropper();
			$jcropper->thumbPath = dirname($model->{$this->attribute})."/thumbs";
			if(!file_exists($jcropper->thumbPath)) DxdUtil::createFolders($jcropper->thumbPath);

			// get the image cropping coordinates (or implement your own method)
			$coords = $jcropper->getCoordsFromPost('imageId');
			// returns the path of the cropped image, source must be an absolute path.
			$thumbnail = $jcropper->crop($model->face, $coords);
			if($thumbnail){
				unlink($model->face);
				$model->face = $thumbnail;
				$model->save();
			}
			$this->controller->redirect($this->returnUrl);
		}
		$this->controller->render($this->cropViewFile,array('model'=>$model));
	}
}