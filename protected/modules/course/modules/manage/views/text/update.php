<?php
$this->course = $course;
$this->breadcrumbs =
 				array($course->name=>array('/course/index/view','id'=>$lesson->course->id),
    			Yii::t('app',"课时管理")=>array('lesson/index','courseId'=>$lesson->courseId),
    			Yii::t('app',"编辑图文"));
?>
<h3 class="side-lined"><?php echo Yii::t('app','编辑图文');?></h3>
<?php $this->renderPartial('_form',array('model'=>$model)); ?>
