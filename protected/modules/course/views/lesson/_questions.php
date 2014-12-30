<?php
/* @var $this LessonController */
/* @var $data Lesson */
		
		$this->widget('booster.widgets.TbListView',array(
				'dataProvider'=>$commentDataProvider,
			'itemView'=>'/lesson/_comment_item',
			'separator'=>'<hr/>',
			'viewData'=>array('lesson'=>$lesson),
			'emptyText'=>Yii::t('app','还没有评论'),
		));
		
?>
