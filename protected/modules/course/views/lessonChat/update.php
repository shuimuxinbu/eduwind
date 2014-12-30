<?php
$this->breadcrumbs=array(
	'Lesson Chats'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LessonChat','url'=>array('index')),
	array('label'=>'Create LessonChat','url'=>array('create')),
	array('label'=>'View LessonChat','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage LessonChat','url'=>array('admin')),
);
?>

<h1>Update LessonChat <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>