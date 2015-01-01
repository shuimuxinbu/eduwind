<?php
?>
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
	<div class="well">
	<?php
$this->renderPartial('_header');
?>		<br/>
		<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'course-rate-form',
    'type'=>'horizontal',
    'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true,),
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>

<h4>网站与管理员设置</h4>
<?php

 echo $form->textFieldGroup($model, 'name',array('class'=>'col-sm-4','value'=>'EduWind'));
 echo $form->textFieldGroup($model, 'subTitle',array('class'=>'col-sm-4','value'=>'又一个EduWind站点'));
 echo $form->textFieldGroup($model, 'adminName',array('class'=>'col-sm-4','value'=>'windwalker'));
  echo $form->textFieldGroup($model, 'adminEmail',array('class'=>'col-sm-4','value'=>'XXX@XXX.com'));
   echo $form->textFieldGroup($model, 'adminPassword',array('class'=>'col-sm-4','value'=>'XXXXXX'));

?>
<h4>邮件服务器设置</h4>
<?php
 echo $form->textFieldGroup($mailer, 'host',array('class'=>'col-sm-4','value'=>'smtp.163.com'));
  echo $form->textFieldGroup($mailer, 'username',array('class'=>'col-sm-4','value'=>'eduwind@163.com'));
  echo $form->textFieldGroup($mailer, 'password',array('class'=>'col-sm-4','value'=>'eduwinduser'));
   echo $form->textFieldGroup($mailer, 'port',array('class'=>'col-sm-4','value'=>'25'));

?>

		<div class="text-center">
		<?php echo CHtml::submitButton('下一步',array('class'=>'btn btn-primary ')); ?>
		</div>

<?php $this->endWidget();?>
	</div>
</div>
</div>
