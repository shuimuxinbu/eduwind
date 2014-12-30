<?php
$this->breadcrumbs=array(
	'Lesson Docs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LessonDoc','url'=>array('index')),
	array('label'=>'Create LessonDoc','url'=>array('create')),
	array('label'=>'Update LessonDoc','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete LessonDoc','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LessonDoc','url'=>array('admin')),
);
?>

<h1>View LessonDoc #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'lessonId',
		'fileId',
		'description',
	),
)); ?>
