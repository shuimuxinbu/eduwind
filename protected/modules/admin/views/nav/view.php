<?php
$this->breadcrumbs=array(
	'Navs'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Nav','url'=>array('index')),
	array('label'=>'Create Nav','url'=>array('create')),
	array('label'=>'Update Nav','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Nav','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Nav','url'=>array('admin')),
);
?>

<h1>View Nav #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'activeRule',
		'weight',
		'url',
	),
)); ?>
