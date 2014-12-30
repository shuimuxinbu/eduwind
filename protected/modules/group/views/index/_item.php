<li style="width:70px" > 
<div>
	<?php
	//var_dump($data->face);
	//$img = CHtml::image(Yii::app()->baseUrl."/".DxdUtil::xImage($data->face, 40, 40),$data->name,array('style'=>'width:40px;height:40px;'));
	$img = CHtml::image(Yii::app()->baseUrl."/".DxdUtil::xImage($data->face, 70, 70),$data->name,array('style'=>'width:70px;height:70px;'));
	echo CHtml::link($img,array('index/view','id'=>$data->id),array(),array('style'=>'display:block;width:70px;height:70px;'));
	?>
</div>
<div style="line-height:16px;margin:5px 0;" class="text-center">
<?php 
echo CHtml::link($data->name,array('view','id'=>$data->id),array('style'=>'margin-top:5px;'));
?>
</div>
</li>