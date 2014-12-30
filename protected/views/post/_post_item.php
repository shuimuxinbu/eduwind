<?php
?>
<div class="pull-left" style="width:100%">
<?php echo CHtml::link($data->title,array('post/view','id'=>$data->id),array('style'=>'font-size:1.2em;font-weight:bold;display:block;padding: 3px 0;'));?>
	<div class="muted">
	<div class="pull-left">by&nbsp;
		
<?php echo CHtml::link($data->user->name,$data->user->pageUrl,array('class'=>'muted dxd-username','data-userId'=>$data->user->id));?>
	<span>&nbsp;&nbsp;<?php echo Yii::t('app','最近回应：'?><?php echo date('Y-m-d H:i',$data->upTime);?></span>
	</div>
<div class="pull-right"><span class="dxd-post-info-item"><span class="dxd-bold"><?php echo $data->commentCount;?></span><?php echo Yii::t('app','回复'?></span><span class="dxd-post-info-item"><span class="dxd-bold"><?php echo $data->viewNum;?></span><?php echo Yii::t('app','浏览');?></span></div>	
	</div>
</div>
<!--  
<table class="pull-right dxd-post-info"  align="center">
<tr style="font-weight: bold;"><td>1</td><td>4</td><td>100</td></tr>
<tr class="muted" style="font-size:0.9em"><td>回复</td><td>顶</td><td>浏览</td></tr>
</table>
-->

<div class="clearfix"></div>


