<?php
/* @var $this NoticeController */
/* @var $data Notice */
$comment = AnswerComment::model()->with('answer.question','user')->findByPk($data['commentId']);
$question = $comment->answer->question;
if(!$comment || !$question) return false;
?>


	<?php echo CHtml::link($comment->user->name,array("/u/index",'id'=>$comment->userId)); echo Yii::t('app','回复了你在')?>
	<?php echo CHtml::link($question->title,array('question/view','id'=>$question->id));?>
	<?Yii::t('app','中的评论')?>
