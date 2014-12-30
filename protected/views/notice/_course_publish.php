<?php
/* @var $this NoticeController */
/* @var $data Notice */
$course = Course::model()->findByPk($data['courseId']);
if(!$course) return false;

?>


	<?php echo Yii::t('app','恭喜，你的课程')?><?php echo CHtml::link($course->name,array("/course/view",'id'=>$course->courseId)); echo Yii::t('app','通过了审核，发布成功！'?>
