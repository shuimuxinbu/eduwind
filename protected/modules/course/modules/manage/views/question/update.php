<?php
$this->breadcrumbs =array($course->name=>array('/course/index/view','id'=>$course->id), 
						Yii::t('app',"课时管理")=>array('lesson/index'),
						Yii::t('app',"测试管理")=>array('quiz/view','id'=>$model->quizId),
						Yii::t('app','更新问题'));
$this->course=$course;
?>
<h3 class="side-lined"><?php echo Yii::t('app','更新问题');?></h3>
<?php 
	$this->renderPartial('_form',array('model'=>$model,'choice'=>$choice,'validatedChoices'=>$validatedChoices))
?>