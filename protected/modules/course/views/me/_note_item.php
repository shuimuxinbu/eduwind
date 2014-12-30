<?php
/* @var $this LessonPrivateNoteController */
/* @var $data LessonPrivateNote */
?>

<div>
<div style="margin-bottom:10px">
<?php 
$lesson = Lesson::model()->findByPk($data->lessonId);
echo CHtml::link($lesson->title,array('lesson/view','id'=>$data->lessonId));?>
</div>
<?php echo $data->content;?>
<?php echo CHtml::link(Yii::t('app',"修改"),array('lesson/view','id'=>$lesson->id),array('class'=>'pull-right muted'));?>
<div class="clearfix"></div>
</div>