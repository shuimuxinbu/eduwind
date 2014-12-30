<?php
class ToggleVoteAction extends CAction{

	/**
	 * 关注或取消赞成
	 * @param unknown_type $id
	 */
	public function run($id,$value){
		$model = $this->controller->loadModel($id,$value);
		$model->toggleVote(Yii::app()->user->id,$value);
		$vote = Vote::model()->findByAttributes(array('voteableEntityId'=>$model->entityId,'userId'=>Yii::app()->user->id));
		if(isset($vote) && $vote){
			if($vote->userId!=$model->userId){
				$result = Notice::send($model->userId, $model->entity->type."_vote_added", array('voteId'=>$vote->id));
			}
		}
		//feed
		//	Feed::send("vote_added", array('voteid'=>$vote->id));

		$this->controller->renderPartial('//vote/result',array('score'=>$model->voteUpNum,'voteUpers'=>$model->getVoteUperDataProvider()->getData()));
	}
}