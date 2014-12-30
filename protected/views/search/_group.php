<?php 
//preg_replace('//is', $replacement, $subject)
$name = Search::highlightWord($data->name, $keyword);
//$introduction = DxdUtil::highlightWord(strip_tags($data->introduction), $keyword);

?>
<div>
	<?php
	//var_dump($data);
	$img = CHtml::image($data->xFace,"",array('style'=>'width:60px;'));
	echo CHtml::link($img,$data->pageUrl,array('style'=>'width:60px;display:block;','class'=>"pull-left"));
	?>
	<div style="margin-left:75px" style="margin-left">
	<?php  
		echo CHtml::link($name,array('group/view','id'=>$data->id));
	?>
	<br/>
	<?php 
		echo mb_substr(strip_tags($data->introduction),0,140,"utf8")."...";
	?>
	</div>
	<div class="clearfix"></div>
</div>


