<?php
if($member &&  !$member->isValid()){
	$url =   Yii::app()->createUrl('course/index/showRebuy',array('id'=>$data->courseId));
}else{
	$url=  Yii::app()->createUrl('course/lesson/view',array('id'=>$data->id));
}?>
<a href="<?php echo $url;?>" class="dxd-lesson-title dxd-dashed-bottom-border" style="display: block;" <?php if($member && !$member->isValid()):?>onclick="openFancyBox(this);return false;";<?php endif;?>>
		<div class="pull-right muted" style="font-size: 0.8em">
		     <span><?php echo $data->viewNum;?><?php echo Yii::t('app','浏览');?></span>
		     
		     </div>

	<span class="muted pull-left"><?php echo Yii::t('app','课时');?>&nbsp;<?php echo $data->number;?>&nbsp;&nbsp;&nbsp;</span>
	
	<div style="margin-left:52px;">
		<?php echo $data->title;?>	
		<?php 
			if($data->mediaType=="quiz"):
			?><span class="text-warning ml10" style="font-size:0.9em"><?php echo Yii::t('app','测验');?></span>
			<?php endif;?>
		<?php if($data->isFree):?>
			<span class="text-warning ml10" style="font-size:0.9em"><?php echo Yii::t('app','免费');?></span>
			<?php endif;?>		
		<!--  
		<div class="muted" style="font-size:0.8em;"><?php //$introduction= strip_tags($data->introduction);echo mb_substr($introduction, 0,70,'utf-8');if(mb_strlen($introduction)>70) echo "..."?></div>
		-->
	</div>
	
</a>
