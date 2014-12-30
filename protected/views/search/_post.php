<?php 
//preg_replace('//is', $replacement, $subject)
$title = Search::highlightWord($data->title, $keyword);
//$introduction = DxdUtil::highlightWord(strip_tags($data->introduction), $keyword);

?>
<div>
	<div>
	<?php  
		echo CHtml::link($title,$data->pageUrl);
	?>
	<br/>
	<div class="muted" style="margin:5px 0">by <?php echo CHtml::link($data->user->name,array('u/index','id'=>$data->userId),array('class'=>'muted'));?>
	<?php echo date('Y-m-d',$data->addTime);?>
	</div>

	<?php 
		echo mb_substr(strip_tags($data->content),0,140,"utf8")."...";
	?>
	</div>
	<div class="clearfix"></div>
</div>
