<?php
/* @var $this CourseController */
/* @var $model Course */
/* @var $form CActiveForm */
?>
<h3 class="dxd-fancybox-header"><?php echo Yii::t('app','导入视频专辑');?></h3>
<div class="dxd-fancybox-body">
<p><?php echo Yii::t('app','请输入视频专辑页面的url地址（在浏览器的地址栏）');?></p>
<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'lesson-play-list-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php // echo $form->textFieldGroup($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	<input type="text" name="url" class="input-block-level"/>
	<div class="row buttons">
<?php $this->widget('booster.widgets.TbButton',array('label'=> Yii::t('app','确定'),'buttonType'=>'submit','context'=>'primary'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>
<div class="dxd-fancybox-footer">
</div>
