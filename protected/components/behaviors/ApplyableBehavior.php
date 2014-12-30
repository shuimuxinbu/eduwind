<?php
//Yii::import("applications.components.behaviors.AbleBehavior");
class ApplyableBehavior extends CBehavior{
	//绑定事件
	public function events(){
		return array(
			'onApplied'=>'handleOnApplied',
		);
	}

	/**
	 * 申请发布事件
	 * @param unknown_type $event
	 */
	public function handleOnApplied($event){
		$owner = $this->getOwner();
		$admins = UserInfo::getAllAdmins();
		foreach($admins as $user){
			Notice::send($user->id, 'entity_applied',array('entityId'=>$owner->entityId));
		}
	}
	/**
	 * 提出发布申请
	 * @param unknown_type $event
	 */
	public function apply($event){
		$owner = $this->getOwner();
		$owner->status = "apply";
		if($owner->save())
			$owner->onApplied(new CEvent());	
	}
}
