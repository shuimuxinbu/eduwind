<?php
$this->breadcrumbs=array(
	'Lesson Chats'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LessonChat','url'=>array('index')),
	array('label'=>'Manage LessonChat','url'=>array('admin')),
);
?>

<h1>Create LessonChat</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>