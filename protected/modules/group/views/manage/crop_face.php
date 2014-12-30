<?php
/* @var $this UserController */
/* @var $model UserInfo */

?>
<?php
/* @var $this CourseManageController */
/* @var $dataProvider CActiveDataProvider */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links'=>array($model->name=>array('//index/view','id'=>$model->id), Yii::t('app',"小组管理")),
));
?>

<div class="row ">

	<div class="col-sm-2 dxd-course-category">
	<?php $this->renderPartial('_side_nav',array('group'=>$model));?>
	</div>
	<div class="col-sm-10">
	<h3 class="side-lined"><?php echo Yii::t('app','小组头像');?></h3>
<p><?php echo Yii::t('app','请上传小组头像')?></p>
<ul>
<li><?php echo Yii::t('app','支持图片格式为*.png,*.jpg,*.jpeg，大小不能超过2MB；');?></li>
</ul>
<p></p>

<?php

$form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'course-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
));
$this->widget('ext.jcrop.EJcrop', array(
    //
    // Image URL
//    'url' => $this->createAbsoluteUrl('/path/to/full/image.jpg'),
	'url'=>Yii::app()->baseUrl."/".$model->face,
	//
    // ALT text for the image
    'alt' => 'Crop This Image',
	'boxHeight'=>200,
    //
    // options for the IMG element
    'htmlOptions' => array('id' => 'imageId'),
    //
    'options' => array(
        'minSize' => array(100, 100),
        'aspectRatio' => 1,
        'onRelease' => "js:function() {ejcrop_cancelCrop(this);}",
    ),
    'setSelect'=>array(0,0,300,300),
));

?>
<div class="pull-right">
<?php $this->widget('booster.widgets.TbButton',array('label'=>Yii::t('app','完成'),'buttonType'=>'submit','context'=>'success'));?>
</div>
<?php $this->endWidget();?>

	</div>
</div>

