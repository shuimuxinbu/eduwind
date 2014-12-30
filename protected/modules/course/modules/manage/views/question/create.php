<?php
$this->breadcrumbs =array($course->name=>array('/course/index/view','id'=>$course->id), 
						Yii::t('app',"课时管理")=>array('lesson/index'),
						Yii::t('app',"测试管理")=>array('quiz/view','lessonId'=>$model->quiz->lesson->id),
						 Yii::t('app','创建问题'));
$this->course=$course;
?>
<h3 class="side-lined"><?php echo Yii::t('app','创建问题');?></h3>
<?php 
	$this->renderPartial('_form',array('model'=>$model,'choice'=>$choice,'validatedChoices'=>$validatedChoices))
?>