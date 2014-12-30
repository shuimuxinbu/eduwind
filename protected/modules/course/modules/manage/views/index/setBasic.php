<?php
/* @var $this CourseManageController */
/* @var $dataProvider CActiveDataProvider */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links'=>array($course->name=>array('/course/index/view','id'=>$course->id), Yii::t('app',"课程管理")),
));
?>

<div class="row ">

	<div class="col-sm-2 dxd-course-category">
	<?php $this->renderPartial('_side_nav',array('course'=>$course));?>
	</div>
	<div class="col-sm-10">
	<h3 class="side-lined"><?php echo Yii::t('app','基本信息');?></h3>
		<h4><?php echo Yii::t('app','课程名称与分类');?></h4>
		<?php $this->renderPartial('_form',array('model'=>$course,'categories'=>$categories));?>
	<!--
		<h4>课程封面图片</h4>
		<?php // $imgUrl = ($course->face && DxdUtil::xImage($course->face,200,100)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($course->face,200,100) : "http://placehold.it/220x110"?>
		<?php //$img = CHtml::image($imgUrl,'image',array('class'=>'pull-left dxd-course-face'));?>
		<?php //echo CHtml::link($img,array('course/setFace','id'=>$course->id),array('class'=>'dxd-set-course-face dxd-fancy-elem','rel'=>'tooltip','data-title'=>'点击设置课程封面图片'));?>
	-->
	</div>
</div>


