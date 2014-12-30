<?php
//Yii::import("applications.components.behaviors.AbleBehavior");
class CommentableBehavior extends AbleBehavior{
	public $itemType = "comment";


	/**
	 * 覆盖父类的时间相应函数
	 * @see AbleBehavior::handleOnAdded()
	 */
	public function handleOnAdded($event){
		$owner = $this->getOwner();
		//更新Num
		$this->refreshCommentNum();

		//feed
		//Feed::send("comment_added", array('entityId'=>$owner->entityId,'commentId'=>$comment->id));

	}

	/**
	 * 返回commentDataProvider
	 */
	public function getCommentDataProvider($c=array()){
		return $this->getItemDataProvider($c);
	}
	/**
	 * 添加comment
	 */
	public function addComment($comment){
		//$this->addItem($comment);
		$comment->addTime = time();
		$comment->userId = Yii::app()->user->id;
		$comment->commentableEntityId = $this->getOwner()->entityId;
		$result = $comment->save();
		if($result){
			if($comment->referId && $comment->userId!=$comment->refer->userId){
				//触发onRecommented事件
			//	$referComment = Comment::model()->findByPk($comment->referId);
			//	$referComment->onRecommentAdded(new CEvent($referComment,array('comment'=>$comment)));
				$type = $comment->commentableEntity->type;	
				Notice::send($comment->refer->userId, $type."_comment_recomment_added", array('commentId'=>$comment->id));			
			}
			$this->onAdded(new CEvent($this,array('comment'=>$comment)));
		}
		return $result;
	}

	public function deleteComment($comment){
		if($comment->delete()){
			$this->refreshCommentNum();
			return true;
		}
		return false;
	}
	/**
	 * 获取顶层comment，（非recomment）
	 * Enter description here ...
	 */
	public function getTopCommentDataProvider($c){

	}

	/**
	 * 获取recomment
	 * Enter description here ...
	 */
	public function getRecommentDataProvider($c=array()){

	}
	/**
	 * 更新数据
	 */
	public function refreshCommentNum(){
		$owner=$this->getOwner();
		if(isset($owner->commentNum)){
			$owner->commentNum = $this->getCommentCount();
			$owner->save();
		}
	}

	/**
	 * 获取反对票数量
	 */
	public function getCommentCount(){
		return Comment::model()->count("commentableEntityId=:entityId",array(':entityId'=>$this->getOwner()->entityId));
	}

}
