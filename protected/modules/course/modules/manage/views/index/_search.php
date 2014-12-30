<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldGroup($model,'id',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'name',array('class'=>'col-sm-5','maxlength'=>64)); ?>

	<?php echo $form->textFieldGroup($model,'userId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'memberNum',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'viewNum',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'fee',array('class'=>'col-sm-5','maxlength'=>7)); ?>

	<?php echo $form->textFieldGroup($model,'entityId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'categoryId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'face',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<?php echo $form->textAreaGroup($model,'introduction',array('rows'=>6, 'cols'=>50, 'class'=>'col-sm-8')); ?>

	<?php echo $form->textFieldGroup($model,'addTime',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'status',array('class'=>'col-sm-5','maxlength'=>32)); ?>

	<?php echo $form->textFieldGroup($model,'rateScore',array('class'=>'col-sm-5','maxlength'=>3)); ?>

	<?php echo $form->textFieldGroup($model,'rateNum',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'targetStudent',array('class'=>'col-sm-5','maxlength'=>1024)); ?>

	<?php echo $form->textFieldGroup($model,'subTitle',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'isTop',array('class'=>'col-sm-5')); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
