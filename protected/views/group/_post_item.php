<div class="dxd-post-item">

<?php
$img = "";
if($data->isTop) $img .= CHtml::image(Yii::app()->baseUrl.'/images/istop.gif');
if($data->isDigest) $img .= CHtml::image(Yii::app()->baseUrl.'/images/isdigest.gif');

 echo CHtml::link($img." ".$data->title,
 				  array('group/post',
 				  		'id'=>$data->id),
 				  		array('class'=>'dxd-post-link')
 				  );
?>
<br />
<div  class="muted">
	by&nbsp;&nbsp;<?php echo CHtml::link($data->user->name,array('//u/index',
												'id'=>$data->user->id),array(
												'class'=>'muted dxd-name',
												'data-userId'=>$data->user->id
											));?>
		&nbsp;&nbsp;&nbsp;<span><?php echo date('Y-m-d',$data->upTime)?></span>
		
		<div class="pull-right" style="font-size:0.9em">
	<span class="dxd-post-info-item"><span class="dxd-bold"><?php echo $data->commentNum;?></span><?php echo Yii::t('app','回复')?></span><span class="dxd-post-info-item"><span class="dxd-bold"><?php echo $data->viewNum;?></span><?php echo Yii::t('app','浏览')?></span>
	</div>
	<div class="clearfix"></div>
</div>
</div>