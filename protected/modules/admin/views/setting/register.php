
<h3 class="side-lined">注册设置</h3>
<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>
<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'partner-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>false,
    'htmlOptions'   =>  array('class'=>'col-sm-9'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

 <?php echo $form->radioButtonListGroup($model, 'isEnabled', array(
     'widgetOptions'    =>  array(
         'data' =>  array(
            '1'=>'打开',
            '0'=>'关闭',
         )
     )
 )); ?>
    <hr/>
		<?php echo $form->textAreaGroup($model,'message',array('class'=>'col-sm-5', 'rows'=>10, 'placeholder'=>'在此粘贴配置内容')); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('保存',array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
