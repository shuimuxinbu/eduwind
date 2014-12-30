<div class="form col-sm-6">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'course-category-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class=" ">
		<?php echo $form->textFieldGroup($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class=" buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-default')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
