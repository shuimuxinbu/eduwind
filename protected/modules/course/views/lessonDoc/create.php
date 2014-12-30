<?php
$this->breadcrumbs=array(
	'Lesson Docs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LessonDoc','url'=>array('index')),
	array('label'=>'Manage LessonDoc','url'=>array('admin')),
);
?>

<h1>Create LessonDoc</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>