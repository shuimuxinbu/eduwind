<?php
$this->breadcrumbs=array(
	'Friend Links'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FriendLink','url'=>array('index')),
	array('label'=>'Manage FriendLink','url'=>array('admin')),
);
?>

<h1>创建友情链接</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>