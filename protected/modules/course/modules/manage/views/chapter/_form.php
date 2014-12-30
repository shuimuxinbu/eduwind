<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
 //   'type'=>'horizontal',
 	'action'=>$model->isNewRecord ? array('create','courseId'=>$model->courseId) : array('update','id'=>$model->id),
)); ?>

	<?php echo $form->errorSummary($model); ?>
 	<?php echo $form->textFieldGroup($model,'title',array('class'=>'col-sm-5'));?>
	<?php echo $form->hiddenField($model, 'courseId');?>
<div class="clearfix"></div>
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','创建') : Yii::t('app','保存'),array('class'=>'pull-right btn btn-primary ml10')); ?>
<?php $this->endWidget();?>
</div>
