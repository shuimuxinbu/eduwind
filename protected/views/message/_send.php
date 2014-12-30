<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-form-'.$toUser->userId,
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('style'=>'margin:0;')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'toUserId',array('value'=>$toUser->userId)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row buttons">
	<?php echo CHtml::ajaxSubmitButton('发送',null,array('success'=>'js:function(data){}'),array('class'=>'btn btn-primary pull-right','id'=>'message-form-submit-btn-'.$toUser->userId))?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->