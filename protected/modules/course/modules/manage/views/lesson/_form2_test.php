<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<div class="form">
<?php
$model->mediaType = "test";
?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
 //   'type'=>'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
)); ?>

	<?php echo $form->errorSummary($model); ?>
 	<?php echo $form->textFieldGroup($model,'title',array('class'=>'input-block-level'));?>
 <?php echo $form->radioButtonListInlineGroup($model, 'isFree', array(
		'1'=>Yii::t('app','是'),
		'0'=>Yii::t('app','否')
    ),array('value'=>$model->isFree?$model->isFree:0)); ?>
 	<?php echo $form->textAreaGroup($model,'introduction',array('class'=>'input-block-level','style'=>'min-height:90px;'));?>
	<?php echo $form->hiddenField($model, 'mediaType',array('value'=>$model->mediaType?$model->mediaType:"video"));?>
<?php $this->endWidget();?>
<style>
.dxd-hidden{
display:none;
}
</style>
