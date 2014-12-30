<?php
/* @var $this CourseRateController */
/* @var $data CourseRate */
?>

<div style="width:80px;height:16px;display:inline-block;position:relative;vertical-align:-2px;" class=" dxd-star-rating-<?php echo intval(round($data->score));?>">

</div>	
	&nbsp;&nbsp;
	<div class="muted" style="display:inline">
	by <?php echo CHtml::link($data->user->name,$data->user->pageUrl,array('class'=>'muted dxd-username','data-userId'=>$data->user->id));?>&nbsp;&nbsp;<?php echo date("Y-m-d H:i",$data->addTime);?>
	</div>
	
	<?php // echo $data->title?>
		<div style="margin-top:5px">
	<?php echo $data->content;?>
</div>
