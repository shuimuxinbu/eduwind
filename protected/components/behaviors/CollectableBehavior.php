<?php
class CollectableBehavior extends AbleBehavior{


	/**
	 * 添加或取消关注
	 */
	public function toggleCollect($userId){
		$owner = $this->getOwner();
		$collect = Collect::model()->findByAttributes(array('userId'=>$userId,'collectableEntityId'=>$owner->entityId));
		if($collect){
			$collect->delete();
			return false;
		}else{
			$collect = new collect;
			$collect->userId = $userId;
			$collect->collectableEntityId = $owner->entityId;
			$collect->addTime = time();
			$collect->save();
			return  true;
		}
		
	}

	/**
	 * 判断一个用户是否跟随者
	 * @param unknown_type $userId
	 */
	public function isCollector($userId){
		$owner = $this->getOwner();
		//if(!$owner->entityId) return false;
		$collect = Collect::model()->findByAttributes(array('userId'=>$userId,'collectableEntityId'=>$owner->entityId));
		if(!$collect) return false;
		return true;
	}

	/**
	 * 返回用户收藏
	 * @param unknown_type $userId
	 * @param unknown_type $pageSize
	 */
	public function getCollectionDataProvider($userId,$pageSize=10){
		$class = get_class($this->getOwner());
	
		$arDataProvider = new CActiveDataProvider($class,
												  array('criteria'=>array('join'=>'inner join ew_collect c on t.entityId=c.collectableEntityId',
																		  'condition'=>'c.userId=:userId',
												  						  'order'=>'c.addTime desc',
												  						  'params'=>array(':userId'=>$userId))
												  ));


		return $arDataProvider;
	}
}