<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldGroup($model,'id',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'lessonId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'fileId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textAreaGroup($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'col-sm-8')); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
