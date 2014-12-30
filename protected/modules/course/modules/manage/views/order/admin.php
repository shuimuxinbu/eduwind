<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Order','url'=>array('index')),
	array('label'=>'Create Order','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('order-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row">
	<div class="col-sm-2 dxd-course-category">
	<?php $this->renderPartial('/index/_side_nav',array('course'=>$course));?>
	</div>
	<div class="col-sm-10">

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<h3 class="side-lined">订单记录</h3>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'order-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'status',
		'subject',
	//	'produceEntityId',
		'userId',
		'meansOfPayment',
		'user.name',
		/*
		'price',
		'addTime',
		'paidTime',
		'tradeNo',
		*/
//		array(
//			'class'=>'booster.widgets.TbButtonColumn',
//		),
	),
)); ?>

	</div>
</div>
