<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'answer-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'userId'); ?>
		<?php echo $form->textField($model,'userId'); ?>
		<?php echo $form->error($model,'userId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'questionid'); ?>
		<?php echo $form->textField($model,'questionid'); ?>
		<?php echo $form->error($model,'questionid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'addTime'); ?>
		<?php echo $form->textField($model,'addTime'); ?>
		<?php echo $form->error($model,'addTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'upTime'); ?>
		<?php echo $form->textField($model,'upTime'); ?>
		<?php echo $form->error($model,'upTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'viewNum'); ?>
		<?php echo $form->textField($model,'viewNum'); ?>
		<?php echo $form->error($model,'viewNum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'count_comment'); ?>
		<?php echo $form->textField($model,'count_comment'); ?>
		<?php echo $form->error($model,'count_comment'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'voteupNum'); ?>
		<?php echo $form->textField($model,'voteupNum'); ?>
		<?php echo $form->error($model,'voteupNum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'count_votedown'); ?>
		<?php echo $form->textField($model,'count_votedown'); ?>
		<?php echo $form->error($model,'count_votedown'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->