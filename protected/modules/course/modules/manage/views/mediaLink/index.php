<?php
/* @var $this MediaLinkController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Media Links',
);

$this->menu=array(
	array('label'=>'Create MediaLink', 'url'=>array('create')),
	array('label'=>'Manage MediaLink', 'url'=>array('admin')),
);
?>

<h1>Media Links</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
