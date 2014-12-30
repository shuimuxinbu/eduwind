<?php
//Yii::import("applications.components.behaviors.AbleBehavior");
class FollowableBehavior extends AbleBehavior{
	public $itemType = "follow";
	public $fans;
	public $autoFollow = true;
	public $userIdAttribute = "userId";
	
	/**
	 * afterSave响应函数,将对象作者默认列入follow表格
	 * @param unknown_type $event
	 */
	public function afterSave($event){
		$owner = $this->getOwner();
		if($owner->isNewRecord){
			$follow = new Follow;
			$follow->userId = $owner->{$this->userIdAttribute};
			$follow->followableEntityId = $owner->entityId;
			$follow->addTime = time();
			$follow->save();
		}
	}
	
	/**
	 * 
	 * (non-PHPdoc)
	 * @see AbleBehavior::handleOnAdded()
	 */
	public function handleOnAdded($event){
		//只对follow用户的情形发通知
		$follow = $event->params['follow'];
		if($follow->followableEntity->type=="user"){
			$user = $follow->followableEntity->getModel();
			if(isset($user->fanNum)){
				$user->fanNum = $this->getFanCount();
				$user->save();
			}
			Notice::send($user->id, "follow_user", array('userId'=>$follow->userId));
		}
	}

	/**
	 * 返回followDataProvider
	 */
	public function getFollowDataProvider($c=array()){
		$c =array('criteria'=>array('with'=>'user'));
		return $this->getItemDataProvider($c);
	}

	/**
	 * 判断一个用户是否跟随者
	 * @param unknown_type $userId
	 */
	public function isFan($userId){
		$owner = $this->getOwner();
		if(!$owner->entityId) return false;
		$follow = Follow::model()->findByAttributes(array('userId'=>$userId,'followableEntityId'=>$owner->entityId));
		if(!$follow) return false;
		return true;
	}
	
	/**
	 * 添加或取消关注
	 */
	public function toggleFollow($userId){
		$owner = $this->getOwner();
		$follow = Follow::model()->findByAttributes(array('userId'=>$userId,'followableEntityId'=>$owner->entityId));
		if($follow){
			$follow->delete();
			$result = false;
		}else{
			$follow = new Follow;
			$follow->userId = $userId;
			$follow->followableEntityId = $owner->entityId;
			$follow->addTime = time();
			$follow->save();
			$result =  true;
		}
		if($follow->isNewRecord) $this->onAdded(new Event($this,array('follow'=>$follow)));
		return $result;
	}
	/**
	 * 获取所有下属follows，返回数组
	 */
	public function getAllFollows(){
		return $this->findAllByAttributes();
	}

	/**
	 * 获取反对票数量
	 */
	public function getFanCount(){
		return Follow::model()->count("followableEntityId=:entityId and value<=0",array(':entityId'=>$this->getOwner()->entityId));
	}
}
