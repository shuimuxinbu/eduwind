<h3 class="side-lined">网站设置</h3>


<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>
<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'open-auth-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	    'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

 <?php echo $form->radioButtonListGroup($model, 'enabled', array(
        '1'=>'是',
        '0'=>'否',
    )); ?>

    <h4>人人账号登录</h4>
     <?php echo $form->radioButtonListGroup($model, 'rennEnabled', array(
        '1'=>'是',
        '0'=>'否',
    )); ?>
    <?php echo $form->textFieldGroup($model,'rennAppId'); ?>
    <?php echo $form->textFieldGroup($model,'rennApiKey'); ?>
    <?php echo $form->textFieldGroup($model,'rennSecretKey'); ?>


	<div class="row buttons">
		<?php echo CHtml::submitButton('保存',array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
