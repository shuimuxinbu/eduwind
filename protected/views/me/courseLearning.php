<?php
$link = CHtml::link('<em>'.Yii::t('app','点击这里找到课程').'</em>',array('course/index'));
$this->widget('booster.widgets.TbThumbnails', array(
	    'dataProvider'=>$courseDataProvider,
	    'template'=>"{items}\n{pager}",
	    'itemView'=>'_courseLearning',
		'emptyText'=>Yii::t('app','还没有开始学习课程 ').$link,
	));
	?>
