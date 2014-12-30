<?php
/* @var $this MediaLinkController */
/* @var $model MediaLink */

$this->breadcrumbs=array(
	'Media Links'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List MediaLink', 'url'=>array('index')),
	array('label'=>'Create MediaLink', 'url'=>array('create')),
	array('label'=>'Update MediaLink', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MediaLink', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MediaLink', 'url'=>array('admin')),
);
?>

<h1>View MediaLink #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'url',
		'source',
		'duration',
		'title',
	),
)); ?>
