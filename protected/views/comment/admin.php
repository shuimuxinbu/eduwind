<?php
/* @var $this TcommentController */
/* @var $model Tcomment */

$this->breadcrumbs=array(
	'Tcomments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Tcomment', 'url'=>array('index')),
	array('label'=>'Create Tcomment', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tcomment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Tcomments</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'), '#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tcomment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'tcommentId',
		'content',
		'create_time',
		'update_time',
		'userId',
		'id',
		/*
		'replyto',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
