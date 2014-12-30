<?php
$this->breadcrumbs=array(
	'Lesson Chats',
);

$this->menu=array(
	array('label'=>'Create LessonChat','url'=>array('create')),
	array('label'=>'Manage LessonChat','url'=>array('admin')),
);
?>

<h1>Lesson Chats</h1>

<?php $this->widget('booster.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
