<?php
/* @var $this UserController */
/* @var $model UserInfo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'user-info-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

		<?php //echo $form->checkBoxListGroup($model,'arrRoles',array('admin'=>'管理员','teacher'=>'人员')); ?>

		<?php echo $form->textFieldGroup($model,'introduction'); ?>

		<?php echo $form->textFieldGroup($model,'status'); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton(($model->isNewRecord ? '创建' : '保存'),array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
