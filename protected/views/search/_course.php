<?php 
//preg_replace('//is', $replacement, $subject)
$name = Search::highlightWord($data->name, $keyword);
//$introduction = DxdUtil::highlightWord(strip_tags($data->introduction), $keyword);

?>
<div>
	<?php
	//var_dump($data);
	$img = CHtml::image($data->xFace,"",array('style'=>'width:100px;'));
	echo CHtml::link($img,array('course/view','id'=>$data->id),array('style'=>'width:100px;display:block;','class'=>"pull-left"));
	?>
	<div style="margin-left:120px" style="margin-left">
	<?php  
		echo CHtml::link($name,$data->pageUrl);
	?>
	<br/>
	<?php 
		echo mb_substr(strip_tags($data->introduction),0,140,"utf8");
	?>
	</div>
	<div class="clearfix"></div>
</div>
