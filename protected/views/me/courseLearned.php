<?php
$this->widget('booster.widgets.TbThumbnails', array(
	    'dataProvider'=>$courseDataProvider,
	    'template'=>"{items}\n{pager}",
	    'itemView'=>'_courseLearned',
		'emptyText'=>Yii::t('app','没有相关课程')
	));
	?>
