<div style="margin-bottom:15px"> 
<div class="pull-left">
	<?php
	$img = CHtml::image(Yii::app()->baseUrl."/".DxdUtil::xImage($data->face, 40, 40),$data->name,array('style'=>'width:40px;height:40px;'));
	echo CHtml::link($img,$data->pageUrl,array('class'=>'dxd-username','data-userId'=>$data->id),array('style'=>'display:block;width:40px;height:50px;'));
	?>
</div>
<div style="line-height:16px;margin-left:50px;">
<?php 
echo CHtml::link($data->name,$data->pageUrl,array('class'=>'dxd-username','data-userId'=>$data->id,'style'=>'margin-top:5px;'));
?>
<div class="pull-right muted">
<?php echo date('m-d H:i',$data->addTime);?>
</div>
	<div style="margin-top: 8px">
	<?php 
	echo $data->bio;
	?>
	</div>
</div>
<div class="clearfix"></div>
</div>
