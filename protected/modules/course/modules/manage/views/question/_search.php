<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldGroup($model,'id',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textAreaGroup($model,'stem',array('rows'=>6, 'cols'=>50, 'class'=>'col-sm-8')); ?>

	<?php echo $form->textFieldGroup($model,'type',array('class'=>'col-sm-5','maxlength'=>8)); ?>

	<?php echo $form->textAreaGroup($model,'choices',array('rows'=>6, 'cols'=>50, 'class'=>'col-sm-8')); ?>

	<?php echo $form->textFieldGroup($model,'quizId',array('class'=>'col-sm-5')); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
