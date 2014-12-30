<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'lesson-doc-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'lessonId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'fileId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textAreaGroup($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'col-sm-8')); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
