<h3 class="side-lined">邮件设置</h3>


<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>
<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'site-form',
	    'type'=>'horizontal',

	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions'   =>  array('class'=>'col-sm-9'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

        <?php echo $form->radioButtonListGroup($model,'enabled',array(
            'widgetOptions' =>  array(
                'data'  =>  array('1'=>"开启",'0'=>'关闭')
            )
        )); ?>
<hr/>
		<?php echo $form->textFieldGroup($model,'host',array('value'=>$model->host)); ?>


		<?php echo $form->textFieldGroup($model,'username',array('value'=>$model->username)); ?>


		<?php echo $form->textFieldGroup($model,'password',array('value'=>$model->password)); ?>

		<?php echo $form->textFieldGroup($model,'port',array('value'=>$model->port)); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('保存',array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
