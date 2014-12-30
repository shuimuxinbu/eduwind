<?php
/* @var $this MessageController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="row">
	<div class="col-sm-2">
		<?php $this->renderPartial("/me/_side_nav",array('user'=>$user));?>
	</div>
	<div class="col-sm-10">
		<h3 class="side-lined"><?php echo Yii::t('app','私信信箱')?></h3>

		<?php $this->widget('booster.widgets.TbListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_latest_item',
			'separator'=>'<hr/>',
			'summaryText'=>Yii::t('app','第').'{start}-{end}'.Yii::t('app','人').' '.Yii::t('app','共').'{count}'.Yii::t('app','人')
		)); ?>
		</div>
</div>
