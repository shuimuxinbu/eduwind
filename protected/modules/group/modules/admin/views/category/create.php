<?php
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Category','url'=>array('index')),
	array('label'=>'Manage Category','url'=>array('admin')),
);
?>

<h1>Create Category</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>