<?php
/* @var $this GroupController */
/* @var $model Post */
?>

<h3><?php echo Yii::t('app','在');?> <em><?php echo $course->name?></em> <?php echo Yii::t('app','发布新帖');?></h3>
<div class="row dxd-group-body">
	<div class="col-sm-9 dxd-left-col">
<?php echo $this->renderPartial('_form', array('model'=>$model,'course'=>$course,'lesson'=>$lesson)); ?>
	</div>
	<div class="col-sm-3">
		<?php echo CHtml::link('< &nbsp;'.Yii::t('app','返回').$course->name,array('/course/post/index','courseId'=>$course->id));?>
	</div>
</div>
