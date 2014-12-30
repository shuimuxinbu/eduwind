		<div class="dxd-dashboard-panel">
			<h4 class="dxd-panel-title"><?php echo Yii::t('app','文档资料');?>&nbsp;<?php if($course->fileCount>0)echo Yii::t('app','（{fileCount} 份）',array('{fileCount}'=>$course->fileCount));?></h4>
			<div class="dxd-panel-content">
				<?php if(Yii::app()->user->id==$course->userId) echo CHtml::link("<i class='icon-upload'></i>".Yii::t('app',"上传文件"),array('courseFile/create','courseId'=>$course->id),array('class'=>'btn pull-right dxd-fancy-elem'));?>
				<div class="clearfix"></div>
				<?php 
				$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$fileDataProvider,
				    'itemView'=>'_file_item',   // refers to the partial view named '_post'
					'summaryText'=>false,
					'emptyText'=>Yii::t('app','暂时还没有文档资料'),
				));
				?>
				<div class="clearfix"></div>
			</div>
		</div>
