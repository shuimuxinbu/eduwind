<?php
/* @var $this UserController */
/* @var $model UserInfo */

$this->breadcrumbs=array(
	'User Infos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserInfo', 'url'=>array('index')),
	array('label'=>'Manage UserInfo', 'url'=>array('admin')),
);
?>

<h1>Create UserInfo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>