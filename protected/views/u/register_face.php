<?php
/* @var $this UserController */
/* @var $model UserInfo */

?>
<h2><?php echo Yii::t('app','上传个人头像');?></h2>
<hr/>
<div class="col-sm-6 center dxd-set-face">
<p>
<?php global $sysSettings;
if(!(isset($sysSettings['mailer']['enabled']) && !$sysSettings['mailer']['enabled'])):?><?php echo Yii::t('app','验证成功！')?><?php endif;?>
<?php echo Yii::t('app','请上传个人头像');?></p>
<ul>
<li><?php echo Yii::t('app','支持图片格式为*.png,*.jpg,*.jpeg，大小不能超过2MB；')?></li>
</ul>
<p></p>
<?php


$form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'course-form',
	'enableAjaxValidation'=>false,
	'action'=>array('u/uploadFace'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
)); ?>

    <?php
    echo $form->fileFieldGroup($userInfo, 'face',array('class'=>'btn'));
?>
<BR/>
	<div class="row buttons pull-right">
	<?php echo CHtml::link(Yii::t('app','跳过'),Yii::app()->baseUrl."/");?>&nbsp;
<?php $this->widget('booster.widgets.TbButton',array('label'=>Yii::t('app','上传'),'buttonType'=>'submit','context'=>'success','htmlOptions'=>array('class'=>'ml10')));?>
	</div>
	<div class="clearfix"></div>
<?php $this->endWidget(); ?>

<div class="pull-right">
<?php //echo CHtml::link('跳过',Yii::app()->baseUrl);?>&nbsp;
<?php //echo CHtml::link('完成',Yii::app()->baseUrl,array('class'=>'btn btn-success ml10'));?>
</div>
</div>
<style>


