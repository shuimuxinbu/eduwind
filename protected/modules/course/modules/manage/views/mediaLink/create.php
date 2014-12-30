<?php
/* @var $this MediaLinkController */
/* @var $model MediaLink */

$this->breadcrumbs=array(
	'Media Links'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MediaLink', 'url'=>array('index')),
	array('label'=>'Manage MediaLink', 'url'=>array('admin')),
);
?>

<h1>Create MediaLink</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>