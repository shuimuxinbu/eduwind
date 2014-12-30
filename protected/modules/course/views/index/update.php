<?php
/* @var $this CourseController */
/* @var $model Course */
/*
$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->courseId=>array('view','id'=>$model->courseId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
	array('label'=>'Create Course', 'url'=>array('create')),
	array('label'=>'View Course', 'url'=>array('view', 'id'=>$model->courseId)),
	array('label'=>'Manage Course', 'url'=>array('admin')),
);*/
?>

<h1>Update Course <?php echo $model->courseId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>