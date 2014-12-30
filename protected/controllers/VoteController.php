<?php

class VoteController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		//'rights',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'users'=>array('@'),
		),
		array('deny', // allow authenticated user to perform 'create' and 'update' actions
				'users'=>array('*'),
		)
		);
	}

	public function allowedActions()
	{
		return 'index, view';
	}
	/**
	 * 为帖子投票
	 * Enter description here ...
	 * @param unknown_type $postid
	 * @param unknown_type $value
	 */
	public function actionAnswer($answerid,$value=0){

		//$vote = new PostVote;
		$vote = AnswerVote::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'answerid'=>$answerid));
		$answer = Answer::model()->with('question')->findByPk($answerid);

		if($vote && $vote->value==$value){
			//再点击赞同（反对），即取消第一次投的赞同（反对）
			$result = $vote->delete();
		}else{
			//赞同（反对）被第一次点击
			$vote or $vote = new AnswerVote;

			$vote->answerid = $answerid;
			$vote->value = $value;
			$vote->userId = Yii::app()->user->id;
			$vote->addTime = time();
			$result = $vote->save();

			//发送系统通知给回答主人
			if($answer->userId!=$vote->userId){
				$notice = new Notice;
				$notice->type = 'vote_answer';
				$notice->setData(array('voteId'=>$vote->getPrimaryKey()));
				$notice->userId = $answer->userId;
				$notice->save();
			}


		}
			
		if($result){
			//		$question = Question::model()->findByPk($answer->question)
			//修改答案投票次数统计
			$answer->voteupNum = $answer->voteupCount;
			$answer->count_votedown = $answer->votedownCount;
			$answer->save();
			//修改问题投票次数统计
			$answer->question->updateVoteCount();
			
			//修改用户被赞数量
			$user = UserInfo::model()->findByPk($answer->userId);
			$user->answerVoteupNum = $user->getAnswerVoteupCount();
			$user->save();
			$score = $answer->voteupCount - $answer->votedownCount;
			$this->renderPartial('result',array('score'=>$score,'voteupers'=>$answer->voteupers));
		}
	}

	/**
	 * 为帖子投票
	 * Enter description here ...
	 * @param unknown_type $postid
	 * @param unknown_type $value
	 */
	public function actionPost($postid=0,$value=0){
		if($postid){
			//$vote = new PostVote;
			$vote = PostVote::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'postid'=>$postid));
			if($vote && $vote->value==$value){
				$result = $vote->delete();
			}else{
				$vote or $vote = new PostVote;
				$vote->postid = $postid;
				$vote->value = $value;
				$vote->userId = Yii::app()->user->id;
				$vote->addTime = time();
				$result = $vote->save();
			}

			if($result){
				$post = Post::model()->with('voteupCount','votedownCount')->findByPk($vote->postid);
				$post->updateVoteCount();
				$score = $post->voteupCount - $post->votedownCount;
				$this->renderPartial('result',array('score'=>$score,'voteupers'=>$post->voteupers));
			}
		}
	}
	/**
	 * 为帖子回复投票
	 * Enter description here ...
	 * @param unknown_type $commentId
	 * @param unknown_type $value
	 */
	public function actionPostComment($commentId=0,$value=0){
		if($commentId){
			//$vote = new PostVote;
			$vote = PostCommentVote::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'commentId'=>$commentId));
			if($vote && $vote->value==$value){
				$result = $vote->delete();
			}else{
				$vote or $vote = new PostCommentVote;
				$vote->commentId = $commentId;
				$vote->value = $value;
				$vote->userId = Yii::app()->user->id;
				$vote->addTime = time();
				$result = $vote->save();
			}

			if($result){
				$postComment = PostComment::model()->findByPk($vote->commentId);
				$score = $postComment->voteupCount - $postComment->votedownCount;
				$this->renderPartial('result',array('score'=>$score,'voteupers'=>$postComment->voteupers));
			}
		}
	}

	/**
	 * 为课程公共笔记投票
	 * Enter description here ...
	 * @param unknown_type $lessonid
	 * @param unknown_type $value
	 */
	public function actionLessonSummary($lessonid=0,$value=0){
		if($lessonid){
			//$vote = new PostVote;
			$vote = LessonSummaryVote::model()->findByAttributes(array('userId'=>Yii::app()->user->id, 'lessonid'=>$lessonid));
			if($vote && $vote->value==$value){
				$vote->delete();
			}else{
				$vote or $vote = new LessonSummaryVote;
				$vote->lessonid = $lessonid;
				$vote->value = $value;
				$vote->userId = Yii::app()->user->id;
				$vote->addTime = time();
				if($vote->save()){

				};

			}
			//返回结果
			$lesson = Lesson::model()->with('summaryVoteCount')->findByPk($vote->lessonid);
			$score = $lesson->summaryVoteCount;
			$this->renderPartial('thanks_result',array('score'=>$score,'voteupers'=>$lesson->voteupers));
		}
	}


	/**
	 * 为个人笔记投票
	 * Enter description here ...
	 * @param unknown_type $lessonid
	 * @param unknown_type $value
	 */
	public function actionLessonNote($noteid){
		//$vote = new PostVote;
		$vote = LessonNoteVote::model()->findByAttributes(array('userId'=>Yii::app()->user->id, 'noteid'=>$noteid));
		if($vote){
			$result = $vote->delete();
		}else{
			$vote or $vote = new LessonNoteVote;
			$vote->noteid = $noteid;
			$vote->userId = Yii::app()->user->id;
			$vote->addTime = time();
			if($vote->save()){
				//发送提醒
				$notice = new Notice;
				$notice->type = 'vote_lesson_note';
				$notice->setData(array('voteId'=>$vote->getPrimaryKey()));
				$notice->userId = $vote->userId;
				$notice->save();
			};
		}

		$note = LessonNote::model()->findByPk($vote->noteid);
		$score = $note->voteCount;
		$this->renderPartial('thanks_result',array('score'=>$score,'voteupers'=>$note->voteupers));
	}

}
