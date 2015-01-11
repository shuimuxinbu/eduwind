<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'text-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'title',array('class'=>'col-sm-5','maxlength'=>255)); ?>

<?php echo $form->textAreaGroup(
    $model,
    'content',
    array(
        'widgetOptions' =>  array(
            'htmlOptions'   =>  array(
                'class' =>  'dxd-kind-editor'
            )
        )
    )
); ?>



	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? '创建' : '保存',
		)); ?>
	</div>


<?php $this->endWidget(); ?>
