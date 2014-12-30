<div class="row">

	<div class="col-sm-9 center">
<?php $this->renderPartial('_header')?>

<?php $this->widget('booster.widgets.TbThumbnails', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_course_note_item',
	'summaryText'=>Yii::t('app',"共 {count} 个笔记本"),
	 'template'=>"{summary}\n<br/>{items}\n{pager}",
)); ?>

	</div>
</div>
