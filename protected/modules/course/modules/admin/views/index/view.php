<?php
/* @var $this CourseController */
/* @var $model Course */
?>

<h1>View Course #<?php echo $model->courseId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'courseId',
		'name',
		'userId',
		'memberNum',
		'viewNum',
		'fee',
		'id',
		'face',
		'introduction',
		'addTime',
		'status',
	),
)); ?>
