<?php ?>
	<div class="my-course-tabs" style="margin-top:20px;margin-bottom:20px;">
		<?php
		$this->widget('booster.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
		array('label'=>Yii::t('app','在学'),'url'=>array('learning'),'active'=>(Yii::app()->controller->action->id=="learning")),
		array('label'=>Yii::t('app','管理'),'url'=>array('manage'),'active'=>(Yii::app()->controller->action->id=="manage")),
		array('label'=>Yii::t('app','收藏'),'url'=>array('collect'),'active'=>(Yii::app()->controller->action->id=="collect")),
		array('label'=>Yii::t('app','笔记'),'url'=>array('noteList'),'active'=>(Yii::app()->controller->action->id=="noteList" or Yii::app()->controller->action->id=="note")),
		)));
		?>
		</div>

<style>
.my-course-tabs {
    text-align: center;
}
.my-course-tabs .nav-pills {
    margin-left: 0;
}
</style>
