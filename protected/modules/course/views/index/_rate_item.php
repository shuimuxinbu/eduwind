<?php
/* @var $this CourseRateController */
/* @var $data CourseRate */
?>

<div>
<!--  
	<div class="muted">3/3人认为有用</div>
-->
<div>

<div style="width:80px;height:16px;display:inline-block;position:relative;vertical-align:-2px;" class="dxd-opacity60 dxd-star-rating-<?php echo intval(round($data->rate));?>"></div>
	
	&nbsp;&nbsp;
	<div class="muted" style="display:inline">
	by <?php echo CHtml::link($data->user->name,$data->user->pageUrl,array('class'=>'muted dxd-username','data-userId'=>$data->user->id));?>&nbsp;&nbsp;<?php echo date("Y-m-d H:i",$data->addTime);?>
	</div>
	
	<?php // echo $data->title?></div>
		<div>
	<?php echo $data->content;?>
	</div>
	


</div>