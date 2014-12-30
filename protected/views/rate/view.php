<?php
/* @var $this RateController */
/* @var $model Rate */

$this->breadcrumbs=array(
	'Rates'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Rate', 'url'=>array('index')),
	array('label'=>'Create Rate', 'url'=>array('create')),
	array('label'=>'Update Rate', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Rate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Rate', 'url'=>array('admin')),
);
?>

<h1>View Rate #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'userId',
		'title',
		'content',
		'addTime',
		'upTime',
		'score',
		'rateableEntityId',
	),
)); ?>
