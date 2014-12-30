<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'nav-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="help-block"> 提示：
		Url即点击该栏目后跳转的地址，如果为站内地址
		<ul>
			<li>
				如果urlFormat为查询式，	课程栏目的url应为/course/index/index。小组栏目的Url应为/group/index/index
			
			</li>
			<li>
				如果urlFormat为路径式，	课程栏目的url应为/index.php?r=course/index/index。小组栏目的Url应为/index.php?r=group/index/index		
			</li>
			
		</ul>
		如果地址为站外地址，则必须以http://或https://开头
	</div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'title',array('class'=>'col-sm-5','maxlength'=>32)); ?>

	<?php echo $form->textFieldGroup($model,'activeRule',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<?php echo $form->textFieldGroup($model,'url',array('class'=>'col-sm-5','maxlength'=>255)); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
