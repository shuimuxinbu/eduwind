<?php
require_once 'AbleBehavior.php';
class VoteableBehavior extends AbleBehavior{
	public $itemType = "vote";


	/**
	 * 返回voteDataProvider
	 */
	public function getVoteDataProvider($c){
		return $this->getItemDataProvider($c);
	}

	/**
	 * (non-PHPdoc)
	 * @see AbleBehavior::handleOnAdded()
	 */
	public function handleOnAdded($event){
		$vote = $event->params['vote'];
		$this->refreshVoteNum();
/*		
		$model = $vote->voteableEntity->getModel();
	//	if($vote->exist()){
			if($vote->userId!=$model->userId){
				$result = Notice::send($model->userId, "vote_added", array('voteid'=>$vote->id));
			}
			//feed
			Feed::send("vote_added", array('voteid'=>$vote->id));
	//	}
*/
	}

	/**
	 * 更新数据
	 */
	public function refreshVoteNum(){
		$owner=$this->getOwner();
		if(isset($owner->voteUpNum)){
			$owner->voteUpNum = $this->getVoteUpCount();
		}
		if(isset($owner->voteDownNum)){
			$owner->voteDownNum = $this->getVoteDownCount();
		}
		if(isset($owner->voteUpNum) || isset($owner->voteDownNum)){
			$result = $owner->save();
		}
	}

	/**
	 * 投票
	 *  1、如果vote不存在，则创建之
	 * 2、如果vote存在，且value相同，则删除之
	 * 3、如果vote存在，且value不同，则改变value
	 * @param unknown_type $userId
	 */
	public function toggleVote($userId,$value){
		$value = $value>0?1:0;
		$owner = $this->getOwner();
		$vote = Vote::model()->findByAttributes(array('voteableEntityId'=>$owner->entityId,'userId'=>$userId));
		//判断是否重复点击
		if($vote && $vote->value==$value){
			$result = $vote->delete();
			$this->refreshVoteNum();
			return $result;
		}
		//以前还没有点击过？
		if(!$vote){
			$vote = new Vote;
			$isNew = true;
			$vote->value=$value;
			$vote->addTime = time();
			$vote->voteableEntityId = $owner->entityId;
			$vote->userId = $userId;
		}

		if($vote->save()){
			if($isNew){
				//触发响应函数
				$this->handleOnAdded(new CEvent($this,array('vote'=>$vote)));
			}
			return true;
		}
	}
	
	/**
	 * 判断一个用户是否跟随者
	 * @param unknown_type $userId
	 */
	public function isVoter($userId){
		$owner = $this->getOwner();
		if(!$owner->entityId) return false;
		$vote = Vote::model()->findByAttributes(array('userId'=>$userId,'voteableEntityId'=>$owner->entityId));
		if(!$vote) return false;
		return true;
	}
	
	/**
	 * 以DataProvider的形式返回投赞成票的用户（UserInfo）
	 */
	public function getVoteUperDataProvider(){
		$entityId = $this->getOwner()->entityId;
		$criteria = new CDbCriteria();
		$criteria->join = "left join ew_vote v on v.userId=t.id";
		$criteria->condition = "v.voteableEntityId=$entityId and v.value>0";
		return new CActiveDataProvider("UserInfo",array('criteria'=>$criteria));
	}
	/**
	 * 获取赞成票数量
	 */
	public function getVoteUpCount(){
		$result = Vote::model()->count("voteableEntityId=:entityId and value>0",array(':entityId'=>$this->getOwner()->entityId));
		return intval($result);
	}
	/**
	 * 获取反对票数量
	 */
	public function getVoteDownCount(){
		$result = Vote::model()->count("voteableEntityId=:entityId and value<=0",array(':entityId'=>$this->getOwner()->entityId));
			return intval($result);
		
	}


}
