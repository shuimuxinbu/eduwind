<?php
?>
<div class="row">
<div class="col-sm-8 center dxd-db-info">
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
 echo $form->textFieldGroup($model, 'host',array('class'=>'col-sm-4','value'=>'localhost'));
  echo $form->textFieldGroup($model, 'dbName',array('class'=>'col-sm-4'));
  echo $form->textFieldGroup($model, 'dbUser',array('class'=>'col-sm-4','value'=>'root'));
   echo $form->textFieldGroup($model, 'dbPassword',array('class'=>'col-sm-4'));
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
