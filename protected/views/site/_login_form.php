<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array("class"=>"well"),
)); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('class'=>'input-block-level')); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('class'=>'input-block-level')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row rememberMe" >
		<?php echo $form->checkBox($model,'rememberMe',array('isChecked'=>"true")); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class=" row buttons">
	

	
		<div class="pull-right">
		<?php echo CHtml::link(Yii::t('app','注册账号'),array('u/register'));?>&nbsp;&nbsp;
		<?php echo CHtml::link(Yii::t('app','忘记密码?'),array('u/forgetPassword'));?>&nbsp;&nbsp;
		<?php echo CHtml::submitButton('登陆',array('class'=>'btn btn-primary')); ?>
		</div>
		<div class="clearfix"></div>
				<div class="pull-left" style="margin-top: 6px;">
		<?php 
		$rennclient = Yii::app()->renrenclient->getClient();
		$code_url = $rennclient->getAuthorizeURL(Yii::app()->renrenclient->redirecturi, 'code');
		$img = CHtml::image(Yii::app()->baseUrl."/images/renren_connect.png");
		echo CHtml::link($img,$code_url);
		?>
		</div>
		<div class="clearfix"></div>
	</div>
<?php $this->endWidget(); ?>


</div>
