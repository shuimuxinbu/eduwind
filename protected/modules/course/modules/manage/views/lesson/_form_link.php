<?php
/* @var $this MediaLinkController */
/* @var $model MediaLink */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'media-link-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->textFieldGroup($model,'url',array('maxlength'=>255,'class'=>'input-block-level')); ?>

	<div class=" buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','创建') : Yii::t('app','保存'),array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
