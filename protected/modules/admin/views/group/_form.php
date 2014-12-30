<?php
/* @var $this GroupController */
/* @var $model Group */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'face'); ?>
		<?php echo $form->textField($model,'face',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'face'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userId'); ?>
		<?php echo $form->textField($model,'userId'); ?>
		<?php echo $form->error($model,'userId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'addTime'); ?>
		<?php echo $form->textField($model,'addTime'); ?>
		<?php echo $form->error($model,'addTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'introduction'); ?>
		<?php echo $form->textArea($model,'introduction',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'introduction'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'memberNum'); ?>
		<?php echo $form->textField($model,'memberNum'); ?>
		<?php echo $form->error($model,'memberNum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'viewNum'); ?>
		<?php echo $form->textField($model,'viewNum'); ?>
		<?php echo $form->error($model,'viewNum'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->