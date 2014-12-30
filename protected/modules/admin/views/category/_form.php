<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'name',array('class'=>'col-sm-5','maxlength'=>64)); ?>

	<?php echo $form->textFieldGroup($model,'parentId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'type',array('class'=>'col-sm-5','maxlength'=>64)); ?>

	<?php echo $form->textFieldGroup($model,'weight',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'userId',array('class'=>'col-sm-5')); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
