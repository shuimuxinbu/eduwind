<?php
/* @var $this CourseController */
/* @var $data Course */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('courseId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->courseId), array('view', 'id'=>$data->courseId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
	<?php echo CHtml::encode($data->userId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userNum')); ?>:</b>
	<?php echo CHtml::encode($data->userNum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('viewNum')); ?>:</b>
	<?php echo CHtml::encode($data->viewNum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fee')); ?>:</b>
	<?php echo CHtml::encode($data->fee); ?>
	<br />
		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::encode($data->id); ?>
	<br />


</div>