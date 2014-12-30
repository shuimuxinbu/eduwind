<?php 
if(get_class($data)=="Lesson"):
?>
<a href="<?php echo Yii::app()->createUrl('course/lesson/view',array('id'=>$data->id))?>" class="dxd-lesson-title " style="display: block;">
		<div class="pull-right muted ml10" style="font-size: 0.8em">
		     <span><?php echo $data->viewNum;?><?php echo Yii::t('app','浏览');?></span>
		     </div>

	<span class="muted pull-left"><?php echo Yii::t('app','课时');?>&nbsp;<?php echo $data->number;?>&nbsp;&nbsp;&nbsp;</span>
	
	<div style="margin-left:62px;">
		<?php echo $data->title;?>	
		<?php 
			if($data->mediaType=="quiz"):
			?><span class="text-warning ml10" style="font-size:0.9em"><?php echo Yii::t('app','测验');?></span>
			<?php endif;?>
		<?php if($data->isFree && (!$member || !$member->inRoles(array('student','teacher','admin')))):?>
			<span class="text-warning ml10" style="font-size:0.9em"><?php echo Yii::t('app','免费');?></span>
			<?php endif;?>	
			<?php if(LessonLearn::model()->checkFinish($data->id, Yii::app()->user->id)){
		     	echo CHtml::image(Yii::app()->baseUrl."/images/tick.png",Yii::t('app','已学完'),array('style'=>'margin-left:10px;height:14px;'));
		     }?>	
		<!--  
		<div class="muted" style="font-size:0.8em;"><?php //$introduction= strip_tags($data->introduction);echo mb_substr($introduction, 0,70,'utf-8');if(mb_strlen($introduction)>70) echo "..."?></div>
		-->
	</div>
	
</a>
<?php else:?>
<div class="dxd-chapter-title">
	<div style="text-align:center">
	<span class=""><?php echo Yii::t('app',' 第 {number} 章  ',array("{number}"=>$data->number));?></span>
		<?php echo $data->title;?>		
	
	</div>
</div>
<?php endif;?>