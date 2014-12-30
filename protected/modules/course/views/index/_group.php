		<div class="dxd-dashboard-panel">
			<h4 class="dxd-panel-title"><?php echo Yii::t('app','相关小组')?></h4>
			<div class="dxd-panel-content">

				<?php 
				$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$groupDataProvider,
				    'itemView'=>'_group_item',   // refers to the partial view named '_post'
					'summaryText'=>false,
					'emptyText'=>Yii::t('app','暂时还没有相关小组'),
				));
				?>
				<div class="clearfix"></div>
			</div>
		</div>
