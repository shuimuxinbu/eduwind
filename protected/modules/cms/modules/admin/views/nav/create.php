<?php
$this->breadcrumbs=array(
	'Navs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Nav','url'=>array('index')),
	array('label'=>'Manage Nav','url'=>array('admin')),
);
?>

<h1>创建栏目</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>