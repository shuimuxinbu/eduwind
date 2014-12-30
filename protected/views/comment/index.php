<?php
/* @var $this TcommentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tcomments',
);

$this->menu=array(
	array('label'=>'Create Tcomment', 'url'=>array('create')),
	array('label'=>'Manage Tcomment', 'url'=>array('admin')),
);
?>

<h1>PostComments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
