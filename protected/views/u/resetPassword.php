<?php
/* @var $this UserController */
/* @var $model UserInfo */

?>

<h2><?php echo Yii::t('app','重新设置密码');?></h2>
<hr/>
<div class="row">
	<div class="col-sm-4 center" style="margin-top:20px;">

<?php
/* @var $this UserController */
/* @var $model UserInfo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'forget-form',
//	'enableAjaxValidation'=>TRUE,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	)
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>64,'class'=>'input-block-level disabled','value'=>$model->email)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<div class="row">
		<?php echo $form->hiddenField($model,'resetPassword',array('value'=>$model->resetPassword)); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'plainPassword'); ?>
		<?php echo $form->passwordField($model,'plainPassword',array('size'=>60,'maxlength'=>64,'class'=>'input-block-level')); ?>
		<?php echo $form->error($model,'plainPassword'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app','重设密码'),array('class'=>'btn  btn-success btn-block pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


	</div>

	
</div>

