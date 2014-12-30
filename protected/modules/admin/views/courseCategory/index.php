<?php
/* @var $this CourseCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Course Categories',
);

$this->menu=array(
	array('label'=>'Create CourseCategory', 'url'=>array('create')),
	array('label'=>'Manage CourseCategory', 'url'=>array('admin')),
);
?>

<h1>Course Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
