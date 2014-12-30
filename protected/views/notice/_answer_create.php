<?php
/* @var $this NoticeController */
/* @var $data Notice */
$answer = Answer::model()->with('user','question')->findByPk($data['answerid']);
if(!$answer)return false;
?>


	<?php echo CHtml::link($answer->user->name,$answer->user->pageUrl); echo Yii::t('app','回答了你关注的问题');?>
	<?php echo CHtml::link($answer->question->title,array('question/view','id'=>$answer->question->id));?>
