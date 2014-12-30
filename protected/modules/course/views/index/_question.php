		<div class="dxd-dashboard-panel">
					<?php echo CHtml::link(Yii::t('app','全部问答'),array('question/index','courseId'=>$course->id),array('class'=>'pull-right dxd-course-edit'));?>
			<h4 class="dxd-panel-title"><?php echo Yii::t('app','问答区');?></h4>
			<div class="dxd-panel-content">
				<?php echo CHtml::link("<i class='icon-pencil'></i>".Yii::t('app',"提问"),array('question/create','courseId'=>$course->id),array('class'=>'btn pull-right'));?>
				<div class="clearfix"></div>
				<?php 
				$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$questionDataProvider,
				    'itemView'=>'_question_item',   // refers to the partial view named '_post'
					'summaryText'=>false,
					'template'=>'{items}',
					'separator' => '<hr style="margin:10px 0;"/>',
					'emptyText'=>Yii::t('app','暂时没有人提问'),
				));
				?>
			</div>
		</div>
