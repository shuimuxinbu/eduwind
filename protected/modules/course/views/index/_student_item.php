<?php if(!$data->user) return false;?>
<div class="dxd-user-face-wrapper"  > 
<div>
	<?php
	$img = CHtml::image($data->user->xFace,$data->user->name,array('style'=>'width:40px;height:40px;'));
	echo CHtml::link($img,$data->user->pageUrl,array('class'=>'dxd-username','data-userid'=>$data->user->id),array('style'=>'display:block;width:40px;height:50px;'));
	?>
</div>
<div style="line-height:16px;margin:5px 0;">
<?php 
echo CHtml::link($data->user->name,$data->user->pageUrl,array('class'=>'dxd-username','data-userid'=>$data->user->id,'style'=>'margin-top:5px;'));
?>
</div>
</div>

