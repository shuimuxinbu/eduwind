<?php
/* @var $this NoticeController */
/* @var $data Notice */
$user = UserInfo::model()->findByPk($data['userId']);
$question = Question::model()->findByPk($data['questionid']);
if(!$question) return false;
?>


	<?php echo CHtml::link($user->name,array("/u/index",'id'=>$user->id)); Yii::t('app','邀请你回答问题');?>
	<?php echo CHtml::link($question->title,array('question/view','id'=>$question->id));?>

