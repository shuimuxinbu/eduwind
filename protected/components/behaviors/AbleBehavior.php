<?php

class AbleBehavior extends CActiveRecordBehavior{
	//例如post，
	public $type;
	//	public $entity;
	//例如‘comment',用于区分子类，在继承的时候必须给$itemType赋值，
	public $itemType;
	//commentableEntityId
	public $ableEntityIdName;
	//commenttableEntity
	public $ableEntityClassName="Entity";
	//Comment
	public $ableClassName;

	function __construct(){
		$this->ableEntityIdName = lcfirst($this->itemType)."ableEntityId";
		$this->ableClassName = ucfirst($this->itemType);
		//绑定事件
		$this->onAdded = array($this,'handleOnAdded');
		$this->onRemoved = array($this,'handleOnRemoved');
		
	}

	public function getAbleEntityIdName(){
		if(!$this->$this->ableEntityIdName)
		$this->ableEntityIdName = lcfirst($this->itemType)."ableEntityId";
		return $this->ableEntityIdName;

	}

	public function getAbleClassName(){
		if(!$this->$this->ableClassName)
		$this->ableClassName = ucfirst($this->itemType);
		return $this->ableClassName;
	}


	public function getType(){
		return lcfirst(get_class($this->getOwner()));
	}
	/**
	 * 创建事件
	 * @param unknown_type $event
	 */
	public function onAdded($event){
		$this->raiseEvent("onAdded",$event);
	}
	/**
	 * 创建事件
	 * @param unknown_type $event
	 */
	public function onRemoved($event){
		$this->raiseEvent("onAdded",$event);
	}

	/**
	 * 创建事件对应的响应函数，默认什么也不做，子类可覆盖之
	 * @param unknown_type $event
	 */
	public function handleOnAdded($event){
		
	}

	/**
	 * 创建事件对应的响应函数，默认什么也不做，子类可覆盖之
	 * @param unknown_type $event
	 */
	public function handleOnRemoved($event){
		
	}
	/**
	 * 返回commentDataProvider
	 */
	public function getItemDataProvider($c=array()){
		$owner = $this->getOwner();
		$entityId = $owner->entityId;
		$c = array_merge_recursive(
		array('criteria'=>array('condition'=>"".$this->ableEntityIdName."=:entityId",
				  						  'params'=>array( ':entityId'=>$entityId))),
		$c);
				return new CActiveDataProvider($this->ableClassName,$c);
	}

	/**
	 * 查找某个owner所有下属item
	 * @param unknown_type $attrs
	 */
	public function findAllByAttributes($attrs=array()){
		$owner = $this->getOwner();
		$attrs = array_merge_recursive($attrs,array("".$this->ableEntityIdName=>$owner->entityId));
		return call_user_func(array($this->ableClassName,'model'))->findAllByAttributes($attrs);
	}
	/**
	 * 添加comment
	 */
	public function addItem(&$item){
		$item->{$this->ableEntityIdName} = $this->getOwner()->entityId;
		$item->addTime = time();
		$item->userId = Yii::app()->user->id;
		return $item->save();
	}
	/**
	 * 删除Item
	 * @param unknown_type $item
	 */
	public function removeItem(&$item){
		$item->delete();
	}


}
