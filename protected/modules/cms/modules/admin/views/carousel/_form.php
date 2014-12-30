<?php
/* @var $this CarouselController */
/* @var $model Carousel */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'carousel-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
)); ?>

	<p class="note">要求所有轮播图片尺寸一致，建议图片长高比约为2.3：1</p>

	<?php echo $form->errorSummary($model); ?>
		<?php echo $form->fileFieldGroup($model,'path',array('size'=>60,'maxlength'=>255,'class'=>'btn btn-default btn-sm')); ?>

	<br/>
	<br/>
	<div >
		<?php echo $form->textFieldGroup($model,'url',array('size'=>60,'maxlength'=>1024,'class'=>'col-sm-6')); ?>
	</div>
<div>
		<?php
		if($model->courseId==0) $model->courseId=null;
		echo $form->textFieldGroup($model,'courseId',array('placeholder'=>"请输入课程Id（数字）")); ?>

</div>
	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '保存' : '修改',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
