<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldGroup($model,'id',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'courseId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'lessonId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'title',array('class'=>'col-sm-5','maxlength'=>128)); ?>

	<?php echo $form->textAreaGroup($model,'content',array('rows'=>6, 'cols'=>50, 'class'=>'col-sm-8')); ?>

	<?php echo $form->textFieldGroup($model,'upTime',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'addTime',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'userId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'commentNum',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'viewNum',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'voteNum',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'isTop',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'isDigest',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'voteUpNum',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'voteDownNum',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'commentableEntityId',array('class'=>'col-sm-5')); ?>

	<?php echo $form->textFieldGroup($model,'entityId',array('class'=>'col-sm-5')); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
