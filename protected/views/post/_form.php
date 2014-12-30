<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'post-form',
	'enableAjaxValidation'=>isset($ajax)?true:false,
	'enableClientValidation'=>false,
	'clientOptions'=>array('validateOnSubmit'=>true,),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('class'=>'input-block-level')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
	<?php  $this->widget('ext.kindeditor.KindEditor',
                    array(
                        'model'=>$model,
                        'attribute'=>'content',
                        )
                    ); ?>
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('style'=>'height:200px;width:100%;','class'=>'dxd-kind-editor')); ?>
		<?php
/*		$this->widget('ext.redactor.ERedactorWidget',array(
					'model'=>$model,
					'attribute'=>'content',
					'htmlOptions'=>array('id'=>'redactor_content'),
					// Redactor options
					'options'=>array(
							'lang'=>'zh_cn',
							'minHeight'=>200, // pixels
					        'fileUpload'=>Yii::app()->createUrl('post/fileUpload',array(
					            'attr'=>'content'
					        )),
					        'fileUploadErrorCallback'=>new CJavaScriptExpression(
					            'function(obj,json) { alert(json.error); }'
					        ),
					        'imageUpload'=>Yii::app()->createUrl('post/imageUpload',array(
					            'attr'=>'content'
					        )),
					        'imageGetJson'=>Yii::app()->createUrl('post/imageList',array(
					            'attr'=>'content'
					        )),
					        'imageUploadErrorCallback'=>new CJavaScriptExpression(
					            'function(obj,json) { alert(json.error); }'
					        ),
					),
			));*/

		?>
		<?php echo $form->error($model,'content'); ?>

	</div>
<br/>
	<div class="row buttons">
			<?php $this->widget('booster.widgets.TbButton', array(
    'context'=>'primary',
    'label'=>$model->isNewRecord ? Yii::t('app','发布') : Yii::t('app','保存'),
    'buttonType'=>'submit',
	'htmlOptions'=>array('class'=>'pull-right')
    )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
