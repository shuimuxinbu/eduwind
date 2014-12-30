		<div class="dxd-dashboard-panel">
			<h4 class="dxd-panel-title"><?php echo isset($title)?$title:Yii::t('app',"成员");?>（<?php echo Yii::t('app','{total}人',array("total"=>$memberDataProvider->totalItemCount))?>）</h4>
			<div class="dxd-panel-content">

				<?php 
			//	var_dump($memberDataProvider);
				$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$memberDataProvider,
				    'itemView'=>'/member/_view',   // refers to the partial view named '_post'
					'summaryText'=>false,
					'emptyText'=>Yii::t('app','暂时还没有成员'),
				));
				?>
				<div class="clearfix"></div>
			</div>
		</div>
