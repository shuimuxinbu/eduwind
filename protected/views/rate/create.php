<?php
/* @var $this RateController */
/* @var $model Rate */

$this->breadcrumbs=array(
	'Rates'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Rate', 'url'=>array('index')),
	array('label'=>'Manage Rate', 'url'=>array('admin')),
);
?>

<h1>Create Rate</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>