<?php
/* @var $this CourseController */
/* @var $model Course */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
	array('label'=>'Create Course', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#course-grid').yiiGridView('update', {
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
<h3 class="side-lined"><?php echo Yii::t('app', '课程列表'); ?></h3>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView', array(
	'id'=>'course-grid',
	'dataProvider'=>$model->search(100),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'userId',
		'memberNum',
		'viewNum',
		'status',
		array(
            'class'=>'booster.widgets.TbButtonColumn',
			'template'=>'{delete}{publish}{unpublish}{top}{untop}',
            'htmlOptions'=>array('style'=>'width: 60px'),
			'buttons'=>array(
				'publish'=>array(
					'label'=>'<i class="glyphicon glyphicon-play"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("setStatus", array("id"=>$data->id,"status"=>Course::STATUS_OK))',
           			 'visible'=>'$data->status!=Course::STATUS_OK',
					'options'=>array('title'=>Yii::t('app', '发布课程')),
				),
				'unpublish'=>array(
					'label'=>'<i class="glyphicon glyphicon-pause"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("setStatus", array("id"=>$data->id,"status"=>Course::STATUS_HIDDEN))',
            		'visible'=>'$data->status == Course::STATUS_OK',
					'options'=>array('title'=>Yii::t('app', '隐藏课程')),
				),
				'top'=>array(
					'label'=>'<i class="glyphicon glyphicon-arrow-up"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("toggleIsTop", array("id"=>$data->id))',
           			 'visible'=>'$data->isTop==0',
					'options'=>array('title'=>Yii::t('app', '置顶课程')),
				),
				'untop'=>array(
					'label'=>'<i class="glyphicon glyphicon-arrow-down"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("toggleIsTop", array("id"=>$data->id))',
           			 'visible'=>'$data->isTop>0',
					'options'=>array('title'=>Yii::t('app', '取消置顶')),
				),
			)
		),
	),
)); ?>
</div>
</div>
</div>

