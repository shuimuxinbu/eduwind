<?php
/* @var $this RateController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Rates',
);

$this->menu=array(
	array('label'=>'Create Rate', 'url'=>array('create')),
	array('label'=>'Manage Rate', 'url'=>array('admin')),
);
?>

<h1>Rates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
