<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'lesson-doc-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->labelEx($model,'fileId');?>
	<?php echo $form->fileField($model,'fileId',array('class'=>'btn')); ?>
	&nbsp;&nbsp;<?php if($model->file) echo $model->file->name;?>
	<p><?php echo Yii::t('app','支持常见文档、视频、音频，压缩文件格式，大小不超过10M');?></p>

	<?php echo $form->textAreaGroup($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'col-sm-6')); ?>

	<div class="pull-right">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('app','上传') : Yii::t('app','保存'),
		)); ?>
	</div>
	<div class="clearfix"></div>

<?php $this->endWidget(); ?>
