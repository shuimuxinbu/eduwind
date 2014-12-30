<?php
$this->breadcrumbs=array(
	'Orders',
);

$this->menu=array(
	array('label'=>'Create Order','url'=>array('create')),
	array('label'=>'Manage Order','url'=>array('admin')),
);
?>

<h1>Orders</h1>

<?php $this->widget('booster.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
