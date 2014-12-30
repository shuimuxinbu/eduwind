<?php
$this->breadcrumbs=array(
	'Lesson Chats'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LessonChat','url'=>array('index')),
	array('label'=>'Create LessonChat','url'=>array('create')),
	array('label'=>'Update LessonChat','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete LessonChat','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LessonChat','url'=>array('admin')),
);
?>

<h1>View LessonChat #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'lessonId',
		'userId',
		'playTime',
		'fontSize',
		'color',
		'mode',
		'addTime',
		'content',
	),
)); ?>
