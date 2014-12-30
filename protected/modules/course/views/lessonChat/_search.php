<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldGroup($model,'id',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'lessonId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'userId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'playTime',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'fontSize',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'color',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'mode',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'addTime',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'content',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
