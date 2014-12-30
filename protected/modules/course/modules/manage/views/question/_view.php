<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stem')); ?>:</b>
	<?php echo CHtml::encode($data->stem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('choices')); ?>:</b>
	<?php echo CHtml::encode($data->choices); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quizId')); ?>:</b>
	<?php echo CHtml::encode($data->quizId); ?>
	<br />


</div>