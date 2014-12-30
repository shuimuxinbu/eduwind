<?php
/* @var $this UserController */
/* @var $model UserInfo */

?>
<h2><?php echo Yii::t('app','上传个人头像');?></h2>
<hr/>
<div class="col-sm-6 center dxd-set-face">
<p><?php echo Yii::t('app','请上传个人头像')?></p>
<ul>
<li><?php echo Yii::t('app','支持图片格式为*.png,*.jpg,*.jpeg，大小不能超过2MB；')?></li>
</ul>
<p></p>

<?php

$form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'course-form',
	'enableAjaxValidation'=>false,
	'action'=>array('u/cropFace'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
));
$this->widget('ext.jcrop.EJcrop', array(
    //
    // Image URL
//    'url' => $this->createAbsoluteUrl('/path/to/full/image.jpg'),
	'url'=>Yii::app()->baseUrl."/".$user->face,
	//
    // ALT text for the image
    'alt' => 'Crop This Image',
	'boxHeight'=>200,
    //
    // options for the IMG element
    'htmlOptions' => array('id' => 'imageId'),
    //
    'options' => array(
        'minSize' => array(50,50),
        'aspectRatio' => 1,
        'onRelease' => "js:function() {ejcrop_cancelCrop(this);}",
    ),
    'setSelect'=>array(0,0,300,300),
));

?>
<div class="pull-right">
<?php $this->widget('booster.widgets.TbButton',array('label'=>Yii::t('app','完成'),'buttonType'=>'submit','type'=>'context'));?>

<?php //echo CHtml::link('跳过',Yii::app()->baseUrl);?>&nbsp;
<?php //echo CHtml::link('完成',Yii::app()->baseUrl,array('class'=>'btn btn-success ml10'));?>

</div>
<?php $this->endWidget();?>
</div>

