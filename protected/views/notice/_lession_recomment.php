<?php
/* @var $this NoticeController */
/* @var $data Notice */
$comment = LessonComment::model()->findByPk($data['commentId']);
if(!$comment) return false;

?>


	<?php echo CHtml::link($comment->user->name,array("//u/index",'id'=>$comment->userId)); echo Yii::t('app','回复了你发表在');?>
	<?php echo CHtml::link($comment->lesson->title,array('lesson/view','id'=>$comment->lesson->lessonid));?>
	<?php echo Yii::t('app','的评论')?>
