<div style="margin-bottom:0px">
<div class="pull-left">
<?php 
$img = CHtml::image($data->user->face,"",array('style'=>'width:48px;height:48px;','class'=>'img-circle'));
echo CHtml::link($img,array('//u/index','id'=>$data->userId));?>
</div>
<div style="margin-left:60px">
<span style="font-size:1.1em">
<?php echo CHtml::link($data->title,array('group/post/view','id'=>$data->id));?>
</span>
<div class="muted mt10">
<div class="pull-right">
<span class="badge badge-success"><?php echo $data->commentNum;?></span>
</div>
<?php echo CHtml::link($data->user->name,$data->user->pageUrl,array('class'=>'muted'));?>&nbsp;&nbsp;
<?php echo date('Y-m-d H:i',$data->upTime);?>
</div>
</div>
<div class="clearfix"></div>
</div>
