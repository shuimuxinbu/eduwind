<?php
class SaveNoteAction extends CAction{

	/**
	 * 保存笔记
	 * @param unknown_type $id
	 */
	public function run($id){
		$model = $this->controller->loadModel($id);
		$note = new Note;
		if(isset($_POST['value'])){
			$note->content = $_POST['value'];
			$note->userId = Yii::app()->user->id;
			echo $model->saveNote($note);
		}
		Yii::app()->end();
	}
}