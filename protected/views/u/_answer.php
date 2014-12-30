<div class="col-sm-9" style="margin-left:0">
	<?php 
		$this->widget('booster.widgets.TbListView', array(
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_answer_item',   // refers to the partial view named '_post'
			'summaryText'=>false,
			'emptyText'=>Yii::t('app','还没有回答'),
			'separator' => '<hr style="margin:15px 0;"/>',
		));
	?>
</div>
