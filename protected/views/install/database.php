<?php
?>
<div class="row">
<div class="col-sm-8 col-sm-offset-2 dxd-db-info">
	<div class="well">
	<?php
$this->renderPartial('_header');
?>		<br/>
		<div class="text-center">
		<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'course-rate-form',
    'type'=>'horizontal',
    'enableClientValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true,),
    'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>

<?php
 echo $form->textFieldGroup($model, 'host',array('class'=>'','value'=>'localhost'));
  echo $form->textFieldGroup($model, 'dbName',array('class'=>''));
  echo $form->textFieldGroup($model, 'dbUser',array('class'=>'','value'=>'root'));
   echo $form->textFieldGroup($model, 'dbPassword',array('class'=>''));
   echo $form->checkboxGroup($model, 'create');
?>
			<?php
/*
	$this->widget('booster.widgets.TbButton', array(
    'type'=>'primary',
    'label'=>"下一步",
    'buttonType'=>'submit',
    )); */

		?>
		<div class="text-center">
		<?php echo CHtml::submitButton('下一步',array('class'=>'btn btn-primary ')); ?>
		</div>

<?php $this->endWidget();?>

</div>
</div>
</div>
</div>
<style>
.dxd-db-info .checkbox input{
	float:none;
}
</style>
