<?php echo CHtml::link($data['comment']->user->name,$data['comment']->user->pageUrl); echo Yii::t('app','回复了你对');?>
	<?php echo CHtml::link($data['lesson']->title,array('course/lesson/view','id'=>$data['lesson']->id));?>
	<?php echo Yii::t('app','的评论')?>