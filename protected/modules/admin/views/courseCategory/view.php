<?php
/* @var $this CourseCategoryController */
/* @var $model CourseCategory */

$this->breadcrumbs=array(
	'Course Categories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CourseCategory', 'url'=>array('index')),
	array('label'=>'Create CourseCategory', 'url'=>array('create')),
	array('label'=>'Update CourseCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CourseCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CourseCategory', 'url'=>array('admin')),
);
?>

<h1>View CourseCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'referid',
		'name',
		'weight',
	),
)); ?>
