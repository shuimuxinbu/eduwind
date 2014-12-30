<?php
/* @var $this TcommentController */
/* @var $data Tcomment */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('postcommentId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->commentId), array('view', 'id'=>$data->commentId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('addTime')); ?>:</b>
	<?php echo CHtml::encode($data->addTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
	<?php echo CHtml::encode($data->userId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::encode($data->id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('referid')); ?>:</b>
	<?php echo CHtml::encode($data->referid); ?>
	<br />
	
	<?php echo CHtml::link(CHtml::encode(Yii::t('app','回复评论')), array('create', 'id'=>$data->id, 'referid'=>$data->commentId)); ?>

</div>