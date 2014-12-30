<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldGroup($model,'id',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'status',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'subject',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'produceEntityId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'userId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'meansOfPayment',array('class'=>'col-sm-5','maxlength'=>9)); ?>

	<?php echo $form->textFieldGroup($model,'price',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'addTime',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'paidTime',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'tradeNo',array('class'=>'col-sm-5','maxlength'=>32)); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
