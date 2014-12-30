<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	'Groups'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Group', 'url'=>array('index')),
	array('label'=>'Create Group', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#group-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="container">
<div class="row">
<div class="col-sm-2">
<?php $this->renderPartial("_side_nav");?>
</div>
<div class="col-sm-10">
<h3 class="side-lined">小组管理</h3>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView', array(
	'id'=>'group-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
//		'face',
		'status',
		'userId',
		array(
			'name'=>'addTime',
			'value'=>'date("Y-m-d H:m:s",$data->addTime)'),
//		'introduction',
		/*
		'status',
		'memberNum',
		'viewNum',
		*/
		array(
			'class'=>'booster.widgets.TbButtonColumn',
			'template'=>'{delete}{publish}{unpublish}{top}{untop}',
					'buttons'=>array(
				'publish'=>array(
					'label'=>'<i class="glyphicon glyphicon-play"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("setStatus", array("id"=>$data->id,"status"=>"ok"))',
           			 'visible'=>'$data->status!="ok"',
					'options'=>array('title'=>"发布小组"),
				),
				'unpublish'=>array(
					'label'=>'<i class="glyphicon glyphicon-pause"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("setStatus", array("id"=>$data->id,"status"=>"unpublished"))',
            		'visible'=>'$data->status == "ok"',
					'options'=>array('title'=>"隐藏小组"),
				),
				'top'=>array(
					'label'=>'<i class="glyphicon glyphicon-arrow-up"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("setTop", array("id"=>$data->id,"isTop"=>1))',
           			 'visible'=>'$data->isTop!="1"',
					'options'=>array('title'=>"置顶小组"),
				),
				'untop'=>array(
					'label'=>'<i class="glyphicon glyphicon-arrow-down"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("setTop", array("id"=>$data->id,"isTop"=>0))',
            		'visible'=>'$data->isTop == "1"',
					'options'=>array('title'=>"取消置顶"),
				),
			)
		),
	),
)); ?>

</div>
</div>
</div>
