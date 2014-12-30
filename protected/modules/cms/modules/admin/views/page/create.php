
<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
	'Pages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Page', 'url'=>array('index')),
	array('label'=>'Manage Page', 'url'=>array('admin')),
);
?>
<h3 class="side-lined">页面管理</h3>
<?php echo CHtml::link('<i class="icon-chevron-left"></i>返回',array('page/index'),array('class'=>'btn btn-default'));?>
<h3>添加页面</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

