<?php
/* @var $this CourseCategoryController */
/* @var $model CourseCategory */

$this->breadcrumbs=array(
	'Course Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CourseCategory', 'url'=>array('index')),
	array('label'=>'Create CourseCategory', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#course-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3 class="side-lined">课程分类</h3>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView', array(
	'id'=>'course-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'referid',
		'name',
		'weight',
		array(
            'class'=>'booster.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}',
            'htmlOptions'=>array('style'=>'width: 60px'),
		),
	),
)); ?>
