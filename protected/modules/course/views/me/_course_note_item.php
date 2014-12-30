<?php
/* @var $this LessonPrivateNoteController */
/* @var $data LessonPrivateNote */
?>

<li class="thumbnail dxd-lesson-private-note-course-item" >
<a style="color:#333;display:block;" href="<?php echo $this->createUrl("note",array('courseId'=>$data->courseId));?>">
<h4 style="text-align:center">
<?php 
$course = Course::model()->findByPk($data->courseId);
echo $course->name;?>
</h4>
<div class="dxd-private-note-content">

	<?php echo mb_substr(strip_tags($data->content),0,130,'utf-8'); ?>
</div>
<br/>
<div class="muted" style="font-size: 0.8em;position: absolute;float: none;bottom: 5px;right: 10px;">
<?php echo Yii::t('app','共 {count} 条笔记',array("{count}"=>$data->siblingCount));?>
</div>
<div class="clearfix"></div>
</a>
</li>