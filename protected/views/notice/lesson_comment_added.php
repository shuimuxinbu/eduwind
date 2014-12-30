<?php
/* @var $this NoticeController */
/* @var $data Notice */
?>
	<?php echo CHtml::link($comment->user->name,$comment->user->pageUrl); echo Yii::t('app','在课时');?>
	<?php echo CHtml::link($lesson->title,array('course/lesson/view','id'=>$lesson->id)); echo Yii::t('app','提了一个疑问：');?>
	<?php echo CHtml::link(mb_substr($comment->content,0,20)."...",array('index/lesson','id'=>$lesson->id));?>
