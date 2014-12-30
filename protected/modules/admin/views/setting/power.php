<h3 class="side-lined">网站设置</h3>


<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>
<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'site-form',
	    'type'=>'horizontal',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>"multipart/form-data"),
)); ?>

	<?php echo $form->errorSummary($model); ?>


		<?php echo $form->textFieldGroup($model,'poweredBy',array('value'=>$model->poweredBy)); ?>
		<?php echo $form->textFieldGroup($model,'poweredByUrl',array('value'=>$model->poweredByUrl)); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('保存',array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
