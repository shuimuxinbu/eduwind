<div class="row">

	<div class="col-sm-9 center">
	<?php $this->renderPartial('_header')?>
<?php
echo CHtml::link('<i class="icon-chevron-left"></i>'.Yii::t('app','返回'),array('noteList'),array('class'=>'btn'));
?>
&nbsp;   &nbsp;
<em>
<?php echo Yii::t('app','所属课程:');?>
<?php echo CHtml::link($course->name,$course->pageUrl);?>
</em>
<div style="margin-top:30px">
<?php $this->widget('booster.widgets.TbListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_note_item',
	'summaryText'=>Yii::t('app','共 {count} 条笔记',array("{count}"=>$count),
	 'template'=>"{summary}\n{items}\n{pager}",
	'separator'=>'<hr/>'
)); ?>

	</div>
	</div>
</div>
