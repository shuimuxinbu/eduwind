
<h3 class="side-lined">网站设置</h3>


<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>
<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'site-form',
//	    'type'=>'horizontal',

	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
		<?php echo $form->textFieldGroup($model,'serverUrl',array('value'=>$model->serverUrl,'class'=>'col-sm-4')); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('保存',array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
