<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'messageid'); ?>
		<?php echo $form->textField($model,'messageid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fromUserId'); ?>
		<?php echo $form->textField($model,'fromUserId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'toUserId'); ?>
		<?php echo $form->textField($model,'toUserId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'addTime'); ?>
		<?php echo $form->textField($model,'addTime'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->