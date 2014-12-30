<?php
/* @var $this TcommentController */
/* @var $model Tcomment */

$this->breadcrumbs=array(
	'Tcomments'=>array('index'),
	$model->commentId,
);

$this->menu=array(
	array('label'=>'List Tcomment', 'url'=>array('index')),
	array('label'=>'Create Tcomment', 'url'=>array('create')),
	array('label'=>'Update Tcomment', 'url'=>array('update', 'id'=>$model->commentId)),
	array('label'=>'Delete Tcomment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->commentId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tcomment', 'url'=>array('admin')),
	array('label'=>Yii::('app','回复评论'), 'url'=>array('create&id='.$model->id.'&referid='.$model->commentId)),
);
?>

<h1>View Tcomment #<?php echo $model->commentId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'commentId',
		'content',
		'addTime',
		'userId',
		'id',
		'referid',
	),
)); ?>
