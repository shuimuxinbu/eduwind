		<div class="dxd-dashboard-panel">
			<h4 class="dxd-panel-title">
			<span style="color:#777">
				<?php if($studentDataProvider->totalItemCount>0) echo  $studentDataProvider->totalItemCount ;?>
			</span><?php echo Yii::t('app','位共同奋斗的同学');?>
			</h4>
			<div class="dxd-panel-content">

				<?php 
			//	var_dump($memberDataProvider);
				$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$studentDataProvider,
				    'itemView'=>'_student_item',   // refers to the partial view named '_post'
					'summaryText'=>false,
                    'template'   =>  '{items}',
					'emptyText'=>Yii::t('app','还没有同学！'),
				));
				?>
			</div>
		</div>

