<?php
/* @var $this TcommentController */
/* @var $model Tcomment */

$this->breadcrumbs=array(
	'Tcomments'=>array('index'),
	$model->tcommentId=>array('view','id'=>$model->tcommentId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tcomment', 'url'=>array('index')),
	array('label'=>'Create Tcomment', 'url'=>array('create')),
	array('label'=>'View Tcomment', 'url'=>array('view', 'id'=>$model->tcommentId)),
	array('label'=>'Manage Tcomment', 'url'=>array('admin')),
);
?>

<h1>Update Tcomment <?php echo $model->tcommentId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>