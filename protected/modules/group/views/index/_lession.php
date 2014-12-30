

<a href="<?php echo Yii::app()->createUrl('lesson/view',array('id'=>$data->lessonid))?>" class="dxd-lesson-title dxd-dashed-bottom-border" style="display: block;">
	<span class="muted pull-left"><?php echo Yii::t('app','课时');?>&nbsp;<?php echo ($index+1);?>&nbsp;&nbsp;&nbsp;</span>
	<div style="margin-left:52px;">
		<?php echo $data->title;?>
		<div class="pull-right muted" style="font-size: 0.8em"><?php echo $data->viewNum;?><?php echo Yii::t('app','浏览');?></div>
		<div class="clearfix"></div>
		<div class="muted" style="font-size:0.8em;"><?php $summary= strip_tags($data->summary);echo mb_substr($summary, 0,70,'utf-8');if(mb_strlen($summary)>70) echo "..."?></div>
	</div>
</a>
