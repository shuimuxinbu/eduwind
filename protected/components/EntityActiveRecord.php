<?php
Class EntityActiveRecord extends CActiveRecord{
	private $_entity;
	/**
	 * 创建事件
	 * Enter description here ...
	 * @param unknown_type $event
	 */		
	public function onCreated($event){
		$this->raiseEvent("onCreated",$event);
	}
	
	/**
	 * 申请发布事件
	 * @param unknown_type $event
	 */		
	public function onApplied($event){
		$this->raiseEvent("handelOnApplied",$event);
	}
	/**
	 * 申请发布事件
	 * @param unknown_type $event
	 */		
	public function onMemberNumChanged($event){
		$this->raiseEvent("onMemberNumChanged",$event);
	}
	/**
	 * 返回对应的Entity
	 */
	public function getEntity(){
		if(!$this->_entity) $this->_entity = Entity::model()->findByAttributes(array('id'=>$this->entityId));
		return $this->_entity;
	}
	
	/**
	 * 注册entity
	 */
	protected function beforeSave(){
		if(!$this->entityId){
			$entity = new Entity;
			$entity->type = lcfirst(get_class($this));
			if($entity->save()){
				$this->entityId = $entity->getPrimaryKey();
				$this->_entity = $entity;
			}
		}
		return parent::beforeSave();
	}
}