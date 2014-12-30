		<div class="dxd-dashboard-panel">
			<h4 class="dxd-panel-title"><?php echo Yii::t('app','授课教师');?></h4>
			<div class="dxd-panel-content">

				<?php 
	$this->widget('booster.widgets.TbListView', array(
	    'dataProvider'=>$teacherDataProvider,
	    'itemView'=>'_teacher_item',   // refers to the partial view named '_post'
		'emptyText'=>Yii::t('app','暂时还没有指定授课教师'),
		'summaryText'=>false,
		'separator'=>'<hr style="margin:10px 0;"/>'
	));
				?>
			</div>
		</div>

