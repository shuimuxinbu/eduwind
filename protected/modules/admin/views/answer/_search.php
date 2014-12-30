<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'userId'); ?>
		<?php echo $form->textField($model,'userId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'questionid'); ?>
		<?php echo $form->textField($model,'questionid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'addTime'); ?>
		<?php echo $form->textField($model,'addTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'upTime'); ?>
		<?php echo $form->textField($model,'upTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'viewNum'); ?>
		<?php echo $form->textField($model,'viewNum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'count_comment'); ?>
		<?php echo $form->textField($model,'count_comment'); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'voteupNum'); ?>
		<?php echo $form->textField($model,'voteupNum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'count_votedown'); ?>
		<?php echo $form->textField($model,'count_votedown'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->