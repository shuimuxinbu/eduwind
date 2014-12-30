<?php
/* @var $this MediaLinkController */
/* @var $model MediaLink */

$this->breadcrumbs=array(
	'Media Links'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MediaLink', 'url'=>array('index')),
	array('label'=>'Create MediaLink', 'url'=>array('create')),
	array('label'=>'View MediaLink', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MediaLink', 'url'=>array('admin')),
);
?>

<h1>Update MediaLink <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>