<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'friend-link-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'title',array('class'=>'col-sm-5','maxlength'=>128)); ?>

	<?php echo $form->textFieldGroup($model,'url',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<?php //echo $form->textFieldGroup($model,'logo',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<div class="text-right">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'label'=>$model->isNewRecord ? '创建' : '保存',
		)); ?>
	</div>
<div class="clearfix"></div>
<?php $this->endWidget(); ?>
