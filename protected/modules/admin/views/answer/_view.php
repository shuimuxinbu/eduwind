<?php
/* @var $this AnswerController */
/* @var $data Answer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
	<?php echo CHtml::encode($data->userId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('questionid')); ?>:</b>
	<?php echo CHtml::encode($data->questionid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('addTime')); ?>:</b>
	<?php echo CHtml::encode($data->addTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upTime')); ?>:</b>
	<?php echo CHtml::encode($data->upTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('viewNum')); ?>:</b>
	<?php echo CHtml::encode($data->viewNum); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('count_comment')); ?>:</b>
	<?php echo CHtml::encode($data->count_comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('count_vote')); ?>:</b>
	<?php echo CHtml::encode($data->count_vote); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('voteupNum')); ?>:</b>
	<?php echo CHtml::encode($data->voteupNum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('count_votedown')); ?>:</b>
	<?php echo CHtml::encode($data->count_votedown); ?>
	<br />

	*/ ?>

</div>