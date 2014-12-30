<?php
/* @var $this CourseController */
/* @var $dataProvider CActiveDataProvider */

?>

<div class="row ">
<?php

?>
	<div class="col-sm-9 center">
<?php $this->renderPartial('_header')?>

		<?php
$link = CHtml::link('<em>'.Yii::t('app','点击这里找到课程').'</em>',array('index/index'));
$this->widget('booster.widgets.TbThumbnails', array(
	    'dataProvider'=>$courseDataProvider,
	    'template'=>"{items}\n{pager}",
	    'itemView'=>'_course_item',
		'emptyText'=>Yii::t('app','没有相关课程 ').$link,
	));
	?>
	</div>
</div>


