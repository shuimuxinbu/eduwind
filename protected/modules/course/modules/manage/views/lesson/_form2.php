<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<div class="form" style="width:600px">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
 //   'type'=>'horizontal',
 	'action'=>$model->isNewRecord ? array('create','courseId'=>$model->courseId) : array('update','id'=>$model->id),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
)); ?>

	<?php echo $form->errorSummary($model); ?>
 	<?php echo $form->textFieldGroup($model,'title',array('class'=>'col-sm-5'));?>
 <?php echo $form->radioButtonListGroup($model, 'isFree', array(
     'widgetOptions' =>  array(
         'data' =>  array(
            '1'=>Yii::t('app','是'),
            '0'=>Yii::t('app','否')
         )
     ),
    )); ?>

    <!-- 课程时长 -->
    <?php echo $form->textFieldGroup($model, 'duration'); ?>

 	<?php echo $form->textAreaGroup($model,'introduction',array('class'=>'input-block-level','style'=>'min-height:90px;'));?>
	 <?php
	 if($model->isNewRecord):
		 if(!$model->mediaType) $model->mediaType="lecture";
		 echo $form->radioButtonListGroup($model, 'mediaType', array(
             'widgetOptions'    =>  array(
                 'data' =>  array(
                    'lecture'=>Yii::t('app','讲座'),
                    'quiz'=>Yii::t('app','测验'),
                 )
             )
	    ));
    endif;?>
 	<?php echo $form->hiddenField($model, 'courseId');?>
<div class="clearfix"></div>
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','创建') : Yii::t('app','保存'),array('class'=>'pull-right btn btn-primary ml10')); ?>
<?php $this->endWidget();?>
<style>
.dxd-hidden{
display:none;
}
</style>
