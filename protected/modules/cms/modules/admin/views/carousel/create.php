<?php
/* @var $this CarouselController */
/* @var $model Carousel */

$this->breadcrumbs=array(
	'Carousels'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Carousel', 'url'=>array('index')),
	array('label'=>'Manage Carousel', 'url'=>array('admin')),
);
?>

<h3>添加图片</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>