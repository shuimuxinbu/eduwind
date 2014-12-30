<?php 
//preg_replace('//is', $replacement, $subject)
$username = Search::highlightWord($data->name, $keyword);
$introduction = Search::highlightWord($data->introduction, $keyword);

?>
<div>
	<?php
	$img = CHtml::image($data->xFace,$username,array('style'=>'width:40px;height:40px;'));
	echo CHtml::link($img."&nbsp;&nbsp;&nbsp;&nbsp;$username",array('u/index','id'=>$data->id),array('class'=>'dxd-username','data-userId'=>$data->id),array('style'=>'width:40px;height:50px;'));
//    echo CHtml::link(,array('u/index','id'=>$data->id),array('class'=>'dxd-username','data-userId'=>$data->id,'style'=>'margin-top:5px;'));
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$introduction;
//	echo CHtml::ajaxLink('通过申请',array('groupMember/setMember','groupid'=>$group->id,'userId'=>$data->id),array('success'=>'js:function(data){window.location.reload();}'),array('class'=>'btn btn-success pull-right'));
	?>
	<div class="clearfix"></div>
</div>

