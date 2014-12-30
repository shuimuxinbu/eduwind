<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User Infos',
);

$this->menu=array(
	array('label'=>'Create UserInfo', 'url'=>array('create')),
	array('label'=>'Manage UserInfo', 'url'=>array('admin')),
);
?>

<h1>User Infos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
