<?php
class UpdateSettingAction extends CAction{
	public $viewFile;
	public $className;
	public function run(){
		$model = new $this->className;
		if(isset($_POST[$this->className])){
			$model->attributes = $_POST[$this->className];
			//			var_dump($_POST['SiteForm']);
			if($model->saveSetting()){
				Yii::app()->user->setFlash('success','保存成功！');
			}else{
				Yii::app()->user->setFlash('error','保存失败！');
			}
		}
		$model->getSetting();
		$this->controller->render($this->viewFile,array('model'=>$model));
	}
}