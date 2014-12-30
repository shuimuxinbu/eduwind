<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldGroup($model,'id',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'title',array('class'=>'col-sm-5','maxlength'=>32)); ?>

	<?php echo $form->textFieldGroup($model,'activeRule',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'weight',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'url',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
