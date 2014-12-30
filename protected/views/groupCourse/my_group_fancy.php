
<h3 class="dxd-fancybox-header"><?php echo Yii::t('app','小组收藏课程')?></h3>
<div class="dxd-fancybox-body">
<p><?php echo Yii::t('app','我管理的小组'?></p>
<?php $this->widget('booster.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'summaryText'=>false,
	'viewData'=>array('courseId'=>$courseId),
	'itemView'=>'_view',
	'emptyText'=>Yii::t('app','没有我管理的小组'),
)); ?>
</div>

<div class="dxd-fancybox-footer">
</div>
