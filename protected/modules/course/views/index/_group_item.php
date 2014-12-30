<div class="dxd-user-face-wrapper" style="width:60px" > 
<div>
	<?php
	//var_dump($data->face);
	//$img = CHtml::image(Yii::app()->baseUrl."/".DxdUtil::xImage($data->face, 40, 40),$data->name,array('style'=>'width:40px;height:40px;'));
	$img = CHtml::image(Yii::app()->baseUrl."/".DxdUtil::xImage($data->face, 60, 60),$data->name,array('style'=>'width:60px;height:60px;'));
	echo CHtml::link($img,array('group/view','id'=>$data->id),array(),array('style'=>'display:block;width:60px;height:50px;'));
	?>
</div>
<div style="line-height:16px;margin:5px 0;">
<?php 
echo CHtml::link($data->name,array('group/view','id'=>$data->id),array('style'=>'margin-top:5px;'));
?>
</div>
</div>