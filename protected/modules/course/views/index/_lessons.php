		<div class="dxd-dashboard-panel">
			<?php  //if(Yii::app()->user->id ==$course->userId)echo CHtml::link('<i class="icon-pencil"></i>编辑',array('lesson/editByCourse','courseId'=>$course->id),array('class'=>'pull-right dxd-course-edit'));?>

			<h4 class="dxd-panel-title"><?php echo Yii::t('app','课时列表');?></h4>

			<div>
				<?php 
				$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$lessonDataProvider,
				    'itemView'=>'_lesson',   // refers to the partial view named '_post'
					'summaryText'=>false,
					'viewData'=>array('pagination'=>$lessonDataProvider->pagination,'member'=>$member),
					'template'=>'{pager}{items}{pager}',
					'emptyText'=>'<div style="padding: 15px;">'.Yii::t('app','课时列表为空').'</div>',
				));
				?>
			</div>
		</div>
	

		
	
	  

