<?php
/* @var $this CourseRateController */
/* @var $model CourseRate */
/* @var $form CActiveForm */
?>
<div class="dxd-hover-show-container dxd-sortable-chapter-inner">
<span class="muted"><?php echo Yii::t('app','第 {number} 章：',array("{number}"=>$data->number))?></span>
<?php 
echo $data->title;
?>		
	<div class="pull-right dxd-hover-show">
	<?php 
	echo CHtml::link('<i class="icon-pencil"></i>'.Yii::t('app','编辑'),array('chapter/update','id'=>$data->id),
															array('onclick'=>'openFancyBox(this);return false;',
																  'data-fancyWidth'=>700,
																  'data-fancyHeight'=>350,
																  'class'=>'ml10'));
													
	echo CHtml::link('<i class="icon-trash"></i>'.Yii::t('app','删除'),array('chapter/delete','id'=>$data->id),
															array('class'=>'ml10',
																  ));
	?>
</div>
<div class="clearfix"></div>
</div>
