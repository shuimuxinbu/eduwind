<?php

?>
<?php
/* @var $this CourseManageController */
/* @var $dataProvider CActiveDataProvider */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links'=>array($lesson->course->name=>array('/course/index/view','id'=>$lesson->course->id), Yii::t('app',"课程管理")),
)); 
?>

<div class="row ">

	<div class="col-sm-2 dxd-course-category">
	<?php $this->renderPartial('/index/_side_nav',array('course'=>$lesson->course));?>
	</div>
	<div class="col-sm-10">
		<h3 class="side-lined"><?php echo Yii::t('app','题库');?></h3>
		<?php echo CHtml::link('<i class="icon-plus icon-white"></i>'.Yii::t('app','添加问题'),array('question/create','quizId'=>$lesson->mediaId),array('class'=>'btn btn-success   mr10'));?>
	</div>
</div>
