<?php
/* @var $this LessonController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lessons',
);

$this->menu=array(
	array('label'=>'Create Lesson', 'url'=>array('create')),
	array('label'=>'Manage Lesson', 'url'=>array('admin')),
);
?>

<h1>Lessons</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
