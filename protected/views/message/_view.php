<?php
/* @var $this MessageController */
/* @var $data Message */
?>

<div>
<?php 
echo CHtml::image($data->fromUser->face,'image',array('class'=>'pull-left','style'=>'width:48px;height:48px;'));?>

<div style="margin-left:62px">
	<div></div><span> <?php echo $data->fromUser->name;?></span>
	&nbsp;&nbsp;<span class="muted"><?php echo date("Y-m-d H:i",$data->addTime);?></span>
	
	<br/>
	<span style="color:#333"><?php echo  $data->content;?></span>
</div>

</div>
<div class="clearfix"></div>