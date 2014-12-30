<?php
$this->breadcrumbs=array(
	'Lesson Docs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LessonDoc','url'=>array('index')),
	array('label'=>'Create LessonDoc','url'=>array('create')),
	array('label'=>'View LessonDoc','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage LessonDoc','url'=>array('admin')),
);
?>

<h1>Update LessonDoc <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>