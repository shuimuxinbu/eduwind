<?php
$this->breadcrumbs=array(
	'Lesson Docs',
);

$this->menu=array(
	array('label'=>'Create LessonDoc','url'=>array('create')),
	array('label'=>'Manage LessonDoc','url'=>array('admin')),
);
?>

<h1>Lesson Docs</h1>

<?php $this->widget('booster.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
