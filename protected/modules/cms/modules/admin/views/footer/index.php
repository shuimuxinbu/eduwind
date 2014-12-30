<?php
/* @var $this FooterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'System Settings',
);

$this->menu=array(
	array('label'=>'Create SystemSetting', 'url'=>array('create')),
	array('label'=>'Manage SystemSetting', 'url'=>array('admin')),
);
?>

<h3 class="side-lined">底部设置</h3>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
