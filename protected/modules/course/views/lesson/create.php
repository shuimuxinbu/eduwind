<?php
/* @var $this LessonController */
/* @var $model Lesson */
/*
$this->breadcrumbs=array(
	'Lessons'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Lesson', 'url'=>array('index')),
	array('label'=>'Manage Lesson', 'url'=>array('admin')),
);*/
?>

<h3 class="dxd-fancybox-header"><?php echo Yii::t('app','添加课时');?></h3>
<div class="dxd-fancybox-content" style="padding-top:5px;">
<p><?php echo Yii::t('app','所属课程：')?><em><?php echo $model->course->name;?></em></p>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>