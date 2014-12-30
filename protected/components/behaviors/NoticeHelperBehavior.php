<?php
//require_once 'MemberableBehavior.php';

class NoticeHelperBehavior extends CBehavior{
	public $compilers = array(
		'comment_added'=>'compileCommentAdded',
		'vote_added'=>'compileVoteAdded',
		'group_publish'=>'compileGroupPublish',
		'comment_recomment_added'=>'compileRecommentAdded',
		);

		/**
		 * 填充owner的"viewFile",和“viewData”
		 * Enter description here ...
		 */
		public function prepareRender(){
			$owner = $this->getOwner();
			if(isset($this->compilers[$owner->type])){
				$result = $this->{$this->compilers[$owner->type]}();
				if($result){
					$owner->viewFile = $result['viewFile'];
					$owner->viewData = $result['viewData'];
					return true;
				}
			}
			return false;
		}

		/**
		 * 编译评论添加类通知
		 */
		public function compileCommentAdded(){
			$owner = $this->getOwner();
			$data = $owner->getData();
			try{
				$comment = Comment::model()->findByPk(isset($data['commentId'])?$data['commentId']:$data['commentid']);
				if(!$comment) throw new Exception;
				$entity = $comment->commentableEntity;
				$model = $entity->getModel();

				$viewFile = "_".$entity->type."_comment_added";
				$viewData = array('comment'=>$comment,$entity->type=>$model);
			}catch(Exception $e){
				return false;
			}
			return array('viewFile'=>$viewFile,'viewData'=>$viewData);
		}
		/**
		 * 编译投票添加类型通知
		 */
		public function compileVoteAdded(){
			$owner = $this->getOwner();
			$data = $owner->getData();
			error_log(print_r($data,true));
			try{
				$voteId = isset($data['voteId']) ? $data['voteId'] : $data['voteid'];
				$vote = Vote::model()->findByPk($voteId);
				if($vote){
					$entity = $vote->voteableEntity;
				}else{
					throw new Exception();
				}
				$model = $entity->getModel();
				$viewFile = "_".$entity->type."_vote_added";
				$viewData = array('vote'=>$vote,$entity->type=>$model);
			}catch(Exception $e){
				return false;
			}
			return array('viewFile'=>$viewFile,'viewData'=>$viewData);
		}
		
		/**
		 * 编译小组发布类型通知
		 */
		public  function compileGroupPublish() {
			$owner = $this->getOwner();
			$data = $owner->getData();
			try{
				$groupId = isset($data['groupId']) ? $data['groupId'] : $data['groupid'];
				$group = Group::model()->findByPk($groupId);
				$viewFile = "_group_published";
				$viewData = array('group'=>$group);
			}catch(Exception $e){
				return false;
			}
			return array('viewFile'=>$viewFile,'viewData'=>$viewData);
		}
		
		/**
		 * 编译回复评论类型通知
		 */
		public  function compileRecommentAdded() {
			$owner = $this->getOwner();
			$data = $owner->getData();
			try{
				$comment = Comment::model()->findByPk(isset($data['commentId'])?$data['commentId']:$data['commentid']);
				if(!$comment) throw new Exception;
				$entity = $comment->commentableEntity;
				$model = $entity->getModel();
				$viewFile = "_".$entity->type."_recomment_added";
				$viewData = array('comment'=>$comment,$entity->type=>$model);
			}catch(Exception $e){
				return false;
			}
			return array('viewFile'=>$viewFile,'viewData'=>$viewData);
		}
		
		
}
