<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subject')); ?>:</b>
	<?php echo CHtml::encode($data->subject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('produceEntityId')); ?>:</b>
	<?php echo CHtml::encode($data->produceEntityId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
	<?php echo CHtml::encode($data->userId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meansOfPayment')); ?>:</b>
	<?php echo CHtml::encode($data->meansOfPayment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('addTime')); ?>:</b>
	<?php echo CHtml::encode($data->addTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paidTime')); ?>:</b>
	<?php echo CHtml::encode($data->paidTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tradeNo')); ?>:</b>
	<?php echo CHtml::encode($data->tradeNo); ?>
	<br />

	*/ ?>

</div>