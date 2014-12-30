<?php
//Yii::import("applications.components.behaviors.AbleBehavior");
class MediaableBehavior extends AbleBehavior{
	public $itemType = "media";

	/**
	 * 覆盖父类的时间相应函数
	 * @see AbleBehavior::handleOnAdded()
	 */
	public function handleOnAdded($event){
		//更新Num
		$this->refreshMediaNum();
		//发送消息
		$media = $event->params['media'];
		$follows = $owner->getAllFollows();
		foreach($follows as $follow){
			if($follow->userId!=$media->userId && $follow->userId!=$media->referId){
				Notice::send($follow->userId, "media_added", array('entityId'=>$owner->entityId,'mediaid'=>$media->id));
			}
		}
		//feed
		Feed::send("media_added", array('entityId'=>$owner->entityId,'mediaid'=>$media->id));

	}

	/**
	 * 返回mediaDataProvider
	 */
	public function getMediaDataProvider($c){
		return $this->getItemDataProvider($c);
	}
	/**
	 * 添加media
	 */
	public function addMedia($media){
		//$this->addItem($media);
		$media->addTime = time();
		$media->userId = Yii::app()->user->id;
		$media->mediaableEntityId = $this->getOwner()->entityId;
		$result = $media->save();
		if($result){
			if($media->referId){
				//触发onRemediaed事件
				$referMedia = Media::model()->findByPk($media->referId);
				$referMedia->onRemediaAdded(new CEvent($referMedia,array('media'=>$media)));
			}
			$this->onAdded(new CEvent($this,array('media'=>$media)));
		}
		return $result;
	}
	
	/**
	 * 更新数据
	 */
	public function refreshMediaNum(){
		$owner=$this->getOwner();
		if(isset($owner->mediaNum)){
			$owner->mediaNum = $this->getMediaCount();
			$owner->save();
		}
	}
	
	/**
	 * 获取反对票数量
	 */
	public function getMediaCount(){
		return Media::model()->count("mediaableEntityId=:entityId and value<=0",array(':entityId'=>$this->getOwner()->entityId));
	}

}
