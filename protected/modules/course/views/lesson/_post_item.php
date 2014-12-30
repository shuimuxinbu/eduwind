<?php
?>
<div class="pull-left" style="width:100%">
<?php 
if($data->isTop) $img= CHtml::image(Yii::app()->baseUrl."/images/istop.gif")."&nbsp;";
else $img="";
echo CHtml::link($img.$data->title,array('post/view','id'=>$data->id),array('style'=>'font-size:1.2em;font-weight:bold;display:block;padding: 3px 0;','target'=>'_blank'));?>
	<div class="muted">
	<div class="pull-left">by&nbsp;
		
<?php echo CHtml::link($data->user->name,$data->user->pageUrl,array('class'=>'muted dxd-username','data-userId'=>$data->user->id));?>
	<span>&nbsp;&nbsp;<?php echo Yii::t('app','最近回应：')?><?php echo date('Y-m-d H:i',$data->upTime);?></span>
	</div>
<div class="pull-right"><span class="dxd-post-info-item"><span class="dxd-bold"><?php echo $data->commentCount;?></span><?php echo Yii::t('app','回复');?></span><span class="dxd-post-info-item"><span class="dxd-bold"><?php echo $data->viewNum;?></span><?php echo Yii::t('app','浏览');?></span></div>	
	</div>
</div>
<div class="clearfix"></div>