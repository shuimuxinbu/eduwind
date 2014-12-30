		<div class="dxd-dashboard-panel">
			<?php echo CHtml::link(Yii::t('app','全部评价'),array('courseRate/index','courseId'=>$course->courseId),array('class'=>'pull-right dxd-course-edit'));?>
			<h4 class="dxd-panel-title"><?php echo Yii::t('app','评价'); if($course->rateCount>0) echo " ( ".$course->rateCount." ) ";?></h4>
			<div class="dxd-panel-content">

				<?php 
				$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$rateDataProvider,
				    'itemView'=>'_rate_item',   // refers to the partial view named '_post'
					'summaryText'=>false,
					'emptyText'=>Yii::t('app','暂时还没有评价'),
					'separator'=>'<hr style="margin:10px 0;"/>'
				));
				?>
				<div class="clearfix"></div>
			</div>
		</div>
