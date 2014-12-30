<?php
//Yii::import("applications.components.behaviors.AbleBehavior");
class RateableBehavior extends AbleBehavior{
	public $itemType = "rate";

	/**
	 * 覆盖父类的时间相应函数
	 * @see AbleBehavior::handleOnAdded()
	 */
	public function handleOnAdded($event){
		$owner = $this->getOwner();
		//更新Num
		$this->refreshRateNum();

		//发送消息
		$rate = $event->params['rate'];
		//$follows = $owner->getAllFollows();
		//	foreach($follows as $follow){
	//	Notice::send($this->getOwner()->userId, "rate_added", array('entityId'=>$owner->entityId,'rateid'=>$rate->id));
		//		}
		//}
		//feed
	//	Feed::send("rate_added", array('entityId'=>$owner->entityId,'rateid'=>$rate->id));
	}

	/**
	 * 返回rateDataProvider
	 */
	public function getRateDataProvider($c=array()){
		return $this->getItemDataProvider($c);
	}
	/**
	 * 1、如果rate不存在，则添加
	 * 2、如果rate已经存在，则修改
	 */
	public function toggleRate($rate){
		//$this->addItem($rate);
		$owner = $this->getOwner();
		$oldRate = Rate::model()->findByAttributes(array('userId'=>$rate->userId,
														'rateableEntityId'=>$owner->entityId));
		if($oldRate){
			$oldRate->score = $rate->score;
			$oldRate->title = $rate->title;
			$oldRate->content = $rate->content;
			$oldRate->upTime = time();
			if($oldRate->save()){
				$this->refreshRateNum();	
				return true;
			}
		}else{
			$rate->addTime = time();
			$rate->upTime=time();
			$rate->userId = Yii::app()->user->id;
			$rate->rateableEntityId = $this->getOwner()->entityId;
			if($rate->save()){
				$this->onAdded(new CEvent($this,array('rate'=>$rate)));
				return true;
			}
		}
		return false;
	}

	/**
	 * 更新数据
	 */
	public function refreshRateNum(){
		$owner=$this->getOwner();
		if(isset($owner->rateNum)){
			$owner->rateNum = $this->getRateCount();
		}
		if(isset($owner->rateScore)){
			$owner->rateScore = $this->getRateAvgScore();
		}
		if(isset($owner->rateNum) || isset($owner->rateScore)){
			$owner->save();
		}
	}

	/**
	 *按条件查找评价
	 */
	public function findRate($c){
		$owner = $this->getOwner();
		$c = array_merge($c,array('rateableEntityId'=>$owner->entityId));
		return Rate::model()->findByAttributes($c);
	}


	/**
	 * 获取反对票数量
	 */
	public function getRateCount(){
		return Rate::model()->count("rateableEntityId=:entityId and score>0",array(':entityId'=>$this->getOwner()->entityId));
	}

	/**
	 * 获取反对票数量
	 */
	public function getRateAvgScore(){
	//	$rate = Rate::model()->findAll(array('select'=>'avg(score) as avgScore','condition'=>'rateableEntityId=:entityId and score>0','params'=>array(':entityId'=>$this->getOwner()->entityId)));
		//return Rate::model()->count("rateableEntityId=:entityId and value<=0",array(':entityId'=>$this->getOwner()->entityId));
	//	var_dump($rate->avgScore);
		return Rate::model()->getAvgScore($this->getOwner()->entityId);
	}


	/**
	 * 判断一个用户是否评价者
	 * @param unknown_type $userId
	 */
	public function hasRated($userId){
		$owner = $this->getOwner();
		if(!$owner->entityId) return false;
		$rate = Rate::model()->findByAttributes(array('userId'=>$userId,'rateableEntityId'=>$owner->entityId));
		if(!$rate) return false;
		return true;
	}

}
