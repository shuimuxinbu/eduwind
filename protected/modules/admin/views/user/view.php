<?php
/* @var $this UserController */
/* @var $model UserInfo */

$this->breadcrumbs=array(
	'User Infos'=>array('index'),
	$model->userId,
);

$this->menu=array(
	array('label'=>'List UserInfo', 'url'=>array('index')),
	array('label'=>'Create UserInfo', 'url'=>array('create')),
	array('label'=>'Update UserInfo', 'url'=>array('update', 'id'=>$model->userId)),
	array('label'=>'Delete UserInfo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->userId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserInfo', 'url'=>array('admin')),
);
?>

<h1>View UserInfo #<?php echo $model->userId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'userId',
		'email',
		'name',
		'isadmin',
		'addTime',
		'upTime',
		'introduction',
		'face',
		'status'
	),
)); ?>
