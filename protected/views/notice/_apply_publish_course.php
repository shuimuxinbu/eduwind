<?php
/* @var $this NoticeController */
/* @var $data Notice */
$course = Course::model()->with('user')->findByPk($data['courseId']);
if(!$course) return false;
?>


	<?php echo $course->user->name; Yii::t('app','申请发布课程'); echo CHtml::link($course->name,array("/course/index/view",'id'=>$course->courseId));?>
