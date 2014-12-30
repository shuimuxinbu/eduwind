<?php
/* @var $this UserController */
/* @var $model UserInfo */

$this->breadcrumbs=array(
	'User Infos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List UserInfo', 'url'=>array('index')),
	array('label'=>'Create UserInfo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-info-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3 class="side-lined">系统日志</h3>


<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php

$this->widget('booster.widgets.TbGridView', array(
	'id'=>'log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'level',
		array('filter'=>false,'name'=>'logtime','value'=>'date("Y-m-d H:i:s",$data->logtime)'),
		'message',
        array('filter'=>false,'name'=>'userId','value'=>'$data->user->name'),
		'ip',
))); ?>
