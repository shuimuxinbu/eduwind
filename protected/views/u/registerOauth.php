<?php
/* @var $this UserController */
/* @var $userInfo UserInfo */

?>

<h2><?php echo Yii::t('app','请完善个人基本信息')?></h2>
<hr/>
	<div class="col-sm-4 center" style="margin-top:20px;">

<?php
/* @var $this UserController */
/* @var $userInfo UserInfo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'info-form',
	'enableAjaxValidation'=>TRUE,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	)
)); ?>

	<?php echo $form->errorSummary($userInfo); ?>


	<div class="row">
		<?php echo $form->labelEx($userInfo,'email'); ?>
		<?php echo $form->textField($userInfo,'email',array('size'=>60,'maxlength'=>64,'class'=>'input-block-level')); ?>
		<?php echo $form->error($userInfo,'email'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($user,'plainPassword'); ?>
		<?php echo $form->passwordField($user,'plainPassword',array('size'=>60,'maxlength'=>200,'class'=>'input-block-level')); ?>
		<?php echo $form->error($user,'plainPassword'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($userInfo,'bio'); ?>
		<?php echo $form->textField($userInfo,'bio',array('size'=>60,'maxlength'=>200,'class'=>'input-block-level')); ?>
		<?php echo $form->error($userInfo,'bio'); ?>
	</div>
		
	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app','确定'),array('class'=>'btn btn-button btn-success btn-block')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


	</div>

<br/><br/><br/>
