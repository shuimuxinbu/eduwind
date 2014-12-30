<?php
/* @var $this LessionController */
/* @var $data->user Lession */
?>


<div>
	<?php echo CHtml::image($data->user->xFace,'image',array('style'=>'width:40px;height:40px;','class'=>'pull-left img-circle'));?>
	
	<div style="margin-left:56px">
		<div>
		<?php echo CHtml::link($data->user->name,$data->user->pageUrl,array('class'=>'muted'));?>
		<div class="pull-right">
			<span><?php echo Yii::t('app','{count} 回复',array("{count}"=>$data->commentNum));?></span> 
		</div>
		<div style="margin:10px 0px 15px 0">
			<?php echo $data->user->bio;?>
		</div>
		<div class="clearfix"></div>
		</div>
	</div>
</div>