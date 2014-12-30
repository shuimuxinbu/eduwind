<?php
/* @var $this CourseController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="row ">
<?php

?>
	<div class="col-sm-2">
		<?php $this->renderPartial('_side_nav',array('keyword'=>$keyword,'count'=>array('course'=>$dataProvider->totalItemCount)));?>
	</div>
	<div class="col-sm-10">
	<?php $this->renderPartial('_form',array('cate'=>'course','keyword'=>$keyword,'count'=>array('course'=>$dataProvider->totalItemCount)))?>

	<h5><?php echo Yii::t('app','搜索')?> "<em><b><?php echo CHtml::link($keyword,"#");?>"</b></em><?php echo Yii::t('app','共得');?> <b><?php echo $dataProvider->totalItemCount;?></b><? echo Yii::t('app','条课程相关结果');?></h5>
	<br/>
	<?php $this->widget('booster.widgets.TbListView', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>"{items}\n{pager}",
	    'itemView'=>'_course',
		'separator'=>'<div style="margin: 20px 0"></div>',
			'viewData'=>array('keyword'=>$keyword),
		'emptyText'=>false
	)); ?>
	</div>
</div>
