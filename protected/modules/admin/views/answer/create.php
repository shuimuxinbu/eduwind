<?php
/* @var $this AnswerController */
/* @var $model Answer */

$this->breadcrumbs=array(
	'Answers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Answer', 'url'=>array('index')),
	array('label'=>'Manage Answer', 'url'=>array('admin')),
);
?>

<h1>Create Answer</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>