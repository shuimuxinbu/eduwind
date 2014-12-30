<?php
class ToggleFollowAction extends CAction{

	/**
	 * 关注或取消关注
	 * @param unknown_type $id
	 */
	public function run($id){
		$model = $this->controller->loadModel($id);
		echo $model->toggleFollow(Yii::app()->user->id);
		Yii::app()->end();
	}
}