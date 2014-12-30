<!--
<h3 class="dxd-fancybox-header">上传个人头像</h3>
<div class="dxd-fancybox-body">
<ul>
<li>支持图片格式为*.png,*.gif,*.jpg,*.jpeg，大小不能超过2MB；</li>
<li>建议图片的长高比约为1：1；</li>
</ul>
<p></p>
<?php
/*
$model = new XUploadForm;
$this->widget('xupload.XUpload', array(
                    'url' => $this->createUrl('me/setFace',array('id'=>$user->id)),
                    'model' => $model,
                    'attribute' => 'file',
					'multiple'=>false,
					'autoUpload'=>true,
		            'options' => array(
		                'maxFileSize' => 3*1024*1024,
		                'acceptFileTypes' => "js:/(\.|\/)(jpe?g|png|gif)$/i",
		            ),
));*/
?>
</div>

<div class="dxd-fancybox-footer">
</div>
-->


<?php
/* @var $this UserController */
/* @var $model UserInfo */
/* @var $form CActiveForm */
?>

<div class="row">
	<div class="col-sm-2 ">
		<?php $this->renderPartial("_side_nav");?>
	</div>
	<div class="col-sm-10">
		<h3 class="side-lined"><?php echo Yii::t('app','账号设置')?></h3>
		<?php $this->widget('booster.widgets.TbMenu', array(
		    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
		    'items'=>array(
		        array('label'=>Yii::t('app','基本信息'), 'url'=>array("//me/setBasic")),
		        array('label'=>Yii::t('app','个人头像'), 'url'=>array("//me/uploadFace")),
		        array('label'=>Yii::t('app','邮件通知'), 'url'=>array("me/receiveMail")),
		        ),
		    "htmlOptions"=>array('class'=>"")
		)); ?>
		<div class="col-sm-6 center">
		<p><?php echo Yii::t('app','当前头像')?></p>
		<?php if($model->face)echo CHtml::image(Yii::app()->baseUrl."/".$model->face, '', array('style'=>'width:300px'));
				else echo "<p>".Yii::t('app','暂无')."</p><p><em>".Yii::t('app','上传后，你的头像会出现在这里')."</em></p>";?>
		<br/>

		<div class="form">

		<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
			'id'=>'set-basic-form',
		//	'enableAjaxValidation'=>TRUE,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array(
        		'enctype' => 'multipart/form-data'
    		)
		)); ?>

			<?php echo $form->errorSummary($model); ?>
			<div class="row">
				<p><?php echo Yii::t('app','更换头像')?></p>
				<?php echo $form->fileField($model,'face',array('class'=>'btn')); ?>
				<?php echo $form->error($model,'face'); ?>
			</div>
			<div class="row buttons" style="margin-top:15px">
			<?php $this->widget('booster.widgets.TbButton', array(
    'context'=>'success',
    'label'=>Yii::t('app','保存'),
    'buttonType'=>'submit',
	'htmlOptions'=>array('class'=>'')
    )); ?>
    			</div>

		<?php $this->endWidget(); ?>

		</div><!-- form -->
		</div>
	</div>
</div>


