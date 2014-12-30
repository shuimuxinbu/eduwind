<?php
/* @var $this CourseController */
/* @var $course Course */
$lesson = new Lesson;
$this->pageTitle = "$course->name";
?>

	<?php echo $this->renderPartial('_header', array('course'=>$course,'member'=>$member)); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="dxd-dashboard-panel">
			<div class="dxd-panel-content">
				<div class="row" style='padding-top:12px;padding-bottom:12px;'>
					<div class="col-sm-10">							
					<?php $this->widget('booster.widgets.TbProgress', array(
					    'type'=>'success', // 'info', 'success' or 'danger'
					    'percent'=>$percent, // the progress
					    'striped'=>true,
					    'animated'=>true,
						'htmlOptions'=>array('style'=>'top:5px;position:relative;')
					)); ?>
					</div>
					<div class="col-sm-2" style="width:130px">
						<?php if($nextLesson): ?>
								<?php echo CHtml::link(Yii::t('app','继续学习'),array('lesson/view','id'=>$nextLesson->id),array('class'=>'btn btn-success','style'=>''));?>
						<?php else:?>
								<?php echo CHtml::link(Yii::t('app','已完成！'),"#",array('class'=>'btn btn-success','style'=>''));?>
						<?php endif;?>
					</div>
					<div class="col-sm-12">
						<div class="pull-left">
							<em><?php echo $user->name;?></em> <?php echo Yii::t('app','已经学习了');?> <span class="text-success"><?php echo $lessonLearnedCount; ?></span> / <span class="text-success"><?php echo $lessonTotalCount;?></span >个课时，完成率 <span class="text-success"><?php echo $percent?> %</span>
							<?php if($percent<60): ?> &nbsp;&nbsp;<span class="text-error"><?php echo Yii::t('app','请继续努力！');?></span><?php endif;?>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>	
<div class="mt20">
<?php 
				$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>new CArrayDataProvider($lessonsAndChapters,array('keyField'=>'id','pagination'=>array('pageSize'=>100))),
				    'itemView'=>'_progress_lessons_and_chapters_item',   // refers to the partial view named '_post'
					'summaryText'=>false,
					'viewData'=>array('user'=>$user),
                    'template'   =>  '{items}',
					'emptyText'=>Yii::t('app','还没有同学！'),
				));
?>
</div>
<br/>
<br/>
<br/>
<br/>
