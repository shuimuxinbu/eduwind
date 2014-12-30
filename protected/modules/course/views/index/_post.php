		<div class="dxd-dashboard-panel">
					<?php echo CHtml::link(Yii::t('app','全部帖子'),array('post/index','courseId'=>$course->id),array('class'=>'pull-right dxd-course-edit'));?>
			<h4 class="dxd-panel-title"><?php echo Yii::t('app','讨论区');?></h4>
			<div class="dxd-panel-content">
				<?php echo CHtml::link("<i class='icon-pencil'></i>".Yii::t('app',"发布新帖"),array('post/create','courseId'=>$course->id),array('class'=>'btn pull-right'));?>
				<div class="clearfix"></div>
				<?php 
				$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$postDataProvider,
				    'itemView'=>'_post_item',   // refers to the partial view named '_post'
					'summaryText'=>false,
					'template'=>'{items}',
					'separator' => '<hr style="margin:10px 0;"/>',
					'emptyText'=>Yii::t('app','暂时还没有人发帖'),
				));
				?>
			</div>
		</div>
