<?php
/* @var $this TcommentController */
/* @var $model Tcomment */

$this->breadcrumbs=array(
	'Tcomments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Tcomment', 'url'=>array('index')),
	array('label'=>'Manage Tcomment', 'url'=>array('admin')),
);
?>

<h1>Create Tcomment</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>