<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'nav-form',
	'enableAjaxValidation'=>false,
	)); ?>

	<div class="help-block"> 提示：
		Url即点击该栏目后跳转的地址，
		<ul>
			<li>
				如果为站内地址，	课程栏目的url应为/course。小组栏目的Url应为/group
			</li>
			<li>
				如果地址为站外地址，则必须以http://或https://开头
			</li>

		</ul>

	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'title',array('class'=>'col-sm-5','maxlength'=>32)); ?>

	<?php echo $form->textFieldGroup($model,'activeRule',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'displayRule',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'url',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
			)); ?>
	</div>

		<?php $this->endWidget(); ?>
