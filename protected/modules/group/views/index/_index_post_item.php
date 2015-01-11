<?php $group =  $data->group;?>
<div class="dxd-index-post-item" style="background-color:white;padding:20px;">
	<div class="group-card pull-left">
  		<div>
		<?php 
  		$imgUrl = ($group->face && DxdUtil::xImage($group->face,100,100)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($group->face,100,100) : "http://placehold.it/100x100"?>
	    <?php $image = CHtml::image($imgUrl,'image',array('style'=>'width: 100px;height:100px;','class'=>'hidden-xs'));
	    	echo CHtml::link($image,array('/group/index/view','id'=>$group->id));?>
	    	</div>
	   <div class="text-center" style="margin-top:22px;">
	    	<?php //echo CHtml::link(mb_substr($data->name,0,32,'utf-8'),array('//course/index/view','id'=>$data->id),array('style'=>""));?>
	   		<div style="font-size:18px"><?php echo CHtml::link(mb_substr($group->name,0,10,'utf-8'),array('//group/index/view','id'=>$group->id),array('style'=>'color:#555;'));?></div>
	   		<!--  
	   		<div class="muted"><small>			<?php echo $group->memberNum;?>&nbsp;成员</small>
	   		</div>
	   		<div style="margin-top:15px">
	    	<?php echo CHtml::link(Yii::t('app','+ 加入小组'),array('view','id'=>$data->id),array('class'=>' group-card-join light-green'));?>
	   		</div>
	   		-->
	    </div>
    </div>
    <div style="margin-left:160px">
<div style="font-size:20px;margin-bottom:20px;">
<?php
 echo CHtml::link($data->title,
 				  array('post/view',
 				  		'id'=>$data->id),
 				  		array('class'=>'light-green')
 				  );
?>
</div>
<div style="margin-bottom:20px;min-height:40px;">
<?php echo mb_substr(strip_tags($data->content), 0,110,'utf-8')."...";?>
</div>
<hr/>
<div class="muted">
<div class="pull-right">
<small>
<?php echo Yii::t('app','评论');?>（<?php echo $data->commentNum;?>）
</small>
</div>
<small>
	<span> <?php echo date('Y-m-d H:i',$data->upTime);?></span>&nbsp;&nbsp;&nbsp;
	<?php echo Yii::t('app','来自成员');?> &nbsp;&nbsp;<?php echo CHtml::link($data->user->name,$data->user->pageUrl,array(
												'class'=>'muted dxd-name light-green',
												'data-userId'=>$data->user->id
											));?>
</small>		
</div>
</div>
	<div class="clearfix"></div>

</div>
