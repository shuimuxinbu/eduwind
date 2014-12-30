		<div class="dxd-dashboard-panel">
			<?php  //if(Yii::app()->user->id ==$course->userId)echo CHtml::link('<i class="icon-pencil"></i>编辑',array('lesson/editByCourse','courseId'=>$course->id),array('class'=>'pull-right dxd-course-edit'));?>

			<h4 class="dxd-panel-title"><?php echo Yii::t('app','课时列表');?></h4>

			<div>
				<?php 
				$dataProvider = new CArrayDataProvider($lessonsAndChapters,array('keyField'=>'weight','pagination'=>array('pageSize'=>100)));
				$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$dataProvider,
				    'itemView'=>'_lessons_and_chapters_item',   // refers to the partial view named '_post'
					'summaryText'=>false,
					'separator'=>'<hr style="margin:0px;	border:1px dashed #f3f3f3;	"/>',
					'viewData'=>array('member'=>$member),
					'template'=>'{pager}{items}{pager}',
					'emptyText'=>'<div style="padding: 15px;">'.Yii::t('app','课时列表为空').'</div>',
				));
				?>
			</div>
		</div>
