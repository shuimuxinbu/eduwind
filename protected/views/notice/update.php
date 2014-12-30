<?php
/* @var $this NoticeController */
/* @var $model Notice */

$this->breadcrumbs=array(
	'Notices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Notice', 'url'=>array('index')),
	array('label'=>'Create Notice', 'url'=>array('create')),
	array('label'=>'View Notice', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Notice', 'url'=>array('admin')),
);
?>

<h1>Update Notice <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>