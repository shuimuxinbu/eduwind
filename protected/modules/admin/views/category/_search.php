<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldGroup($model,'id',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'name',array('class'=>'col-sm-5','maxlength'=>64)); ?>

	<?php echo $form->textFieldGroup($model,'parentId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'type',array('class'=>'col-sm-5','maxlength'=>64)); ?>

	<?php echo $form->textFieldGroup($model,'weight',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'userId',array('class'=>'col-sm-5')); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
