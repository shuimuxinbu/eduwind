<?php
/* @var $this CourseController */
/* @var $model Course */
/*
$this->breadcrumbs=array(
	'Courses'=>array('index'),
	'创建课程',
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
	array('label'=>'Manage Course', 'url'=>array('admin')),
);*/
?>
<h1><?php echo Yii::t('app','创建课程');?></h1>
<div class="row">
	<div class="col-sm-6">

		<?php echo $this->renderPartial('_form', array('model'=>$model,'categorys'=>$categorys)); ?>
	</div>

	<div class="col-sm-6">
		<div style="border-left:1px solid #ccc;padding:5px 0 40px 20px;">
				<h3><?php echo Yii::t('app','三步创建你的课程：');?></h3>
				<ol>
					<li><?php echo Yii::t('app','填写课程名字和课程分类')?></li>
					<li><?php echo Yii::t('app','完善课程内容')?></li>
					<li><?php echo Yii::t('app','申请发布！')?></li>
				</ol>
		</div>

	</div>
</div>

 <br/> <br/> <br/> <br/> <br/> <br/> <br/>
