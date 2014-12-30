<h3 class="side-lined">云存储设置</h3>


<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>
<div class="form col-sm-9">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'site-form',
	    'type'=>'horizontal',

	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
		 <?php echo $form->radioButtonListGroup($model, 'storage', array(
             'widgetOptions'    =>  array(
                 'data' =>  array(
                    'local'=>'上传视频到本地',
                    'cloud'=>'上传视频到云服务器（<a href="http://eduwind.com/index.php?r=service" target="_blank">联系我们</a>）',
                 )
             )
	    )); ?>

		<?php echo $form->textFieldGroup($model,'accessKey',array('value'=>$model->accessKey)); ?>

		<?php echo $form->textFieldGroup($model,'secretKey',array('value'=>$model->secretKey)); ?>


		<?php echo $form->textFieldGroup($model,'bucket'); ?>
		<?php echo $form->textFieldGroup($model,'apiServer',array('value'=>$model->apiServer)); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('保存',array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
