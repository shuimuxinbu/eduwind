<?php
//Yii::import("applications.components.behaviors.AbleBehavior");
class NoteableBehavior extends AbleBehavior{
	public $itemType = "note";


	/**
	 * 返回noteDataProvider
	 */
	public function getNoteDataProvider($c=array()){
		return $this->getItemDataProvider($c);
	}
	/**
	 * 写note
	 */
	public function saveNote($note){
		$owner = $this->getOwner();
		if(!$note->userId) $note->userId = Yii::app()->user->id;
		$oldNote = Note::model()->findByAttributes(array('noteableEntityId'=>$owner->entityId,'userId'=>$note->userId));
		if($oldNote){		
			$oldNote->title = $note->title;
			$oldNote->content = $note->content;
			$oldNote->upTime = time();
			return $oldNote->save();
		}else{
			$note->addTime = time();
			$note->upTime = time();
			$note->userId = Yii::app()->user->id;
			$note->noteableEntityId = $this->getOwner()->entityId;
			$result = $note->save();
			return $result;
		}

	}

	/**
	 * 查找一条笔记
	 * @param unknown_type $c
	 */
	public function findNote($c=array()){
		$owner = $this->getOwner();
		if($owner->entityId){
			$c = array_merge_recursive(array('noteableEntityId'=>$owner->entityId),$c);
		}
		return Note::model()->findByAttributes($c);
	}

	/**
	 * 更新数据
	 */
	public function refreshNoteNum(){
		$owner=$this->getOwner();
		if(isset($owner->noteNum)){
			$owner->noteNum = $this->getNoteCount();
			$owner->save();
		}
	}

	/**
	 * 获取反对票数量
	 */
	public function getNoteCount(){
		return Note::model()->count("noteableEntityId=:entityId and value<=0",array(':entityId'=>$this->getOwner()->entityId));
	}

}
