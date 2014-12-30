<?php
//require_once 'MemberableBehavior.php';

class CommentHelperBehavior extends CBehavior{
	//绑定事件
	public function events(){
		return array(
			'onRecommentAdded'=>'handleOnRecommentAdded',
		);
	}
	/**
	 * 处理被回复事件
	 */
	public function handleOnRecommentAdded($event){
		$owner=$this->getOwner();
		$comment = $event->params['comment'];
		if($owner->userId!=$comment->userId){
			return Notice::send($owner->userId, "comment_recomment_added", array('commentId'=>$comment->id));			
		}
	}
}
