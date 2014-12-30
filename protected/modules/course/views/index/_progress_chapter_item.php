<?php ?>
<div style="border-top:1px solid #ddd;padding-top:20px;">
	<div class="row">
		<div class="col-sm-3">	
			<div style="padding-left:20px;color:#666;">	
				<span class="lead"><?php echo Yii::t('app','第 {number} 章',array('{number}'=>$data->number));?>
				<?php echo $data->title;?>	
				</span>	
			</div>
		</div>
		<div class="col-sm-9">
			<div style="border-left:1px dashed #ddd;padding-left:25px;padding-bottom:20px;">
				<?php 
					$this->widget('booster.widgets.TbListView', array(
					    'dataProvider'=>new CArrayDataProvider($data->lessons,array('keyField'=>'id','pagination'=>array('pageSize'=>100))),
					    'itemView'=>'_progress_lesson_item',   // refers to the partial view named '_post'
						'summaryText'=>false,
	                    'template'   =>  '{items}',
						'viewData'=>array('user'=>$user),
						'emptyText'=>Yii::t('app','还没有课时！'),
					));
				?>
			</div>
		</div>
	</div>

</div>
