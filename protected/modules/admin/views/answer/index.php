<?php
/* @var $this AnswerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Answers',
);

$this->menu=array(
	array('label'=>'Create Answer', 'url'=>array('create')),
	array('label'=>'Manage Answer', 'url'=>array('admin')),
);
?>

<h1>Answers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
