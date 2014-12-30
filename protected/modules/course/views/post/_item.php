<?php
/* @var $this LessionController */
/* @var $data Lession */
?>


<div>
	<?php echo CHtml::image($data->user->xFace,'image',array('style'=>'width:40px;height:40px;','class'=>'pull-left img-circle'));?>
	<div style="margin-left:56px">
		<?php echo CHtml::link($data->user->name,$data->user->pageUrl,array('class'=>'muted'));?>
		<div style="margin:10px 0px 15px 0">
			<?php echo $data->content;?>
		</div>
		<div style="font-size:0.95em">
		<span class="muted">
		<?php echo date('m-d H:i',$data->addTime);?></span>
		
		<?php echo CHtml::link('<i class="icon-comment"></i>&nbsp;'.Yii::t('app','{count} 回复',array("{count}"=>$data->commentNum)),array('post/view','id'=>$data->id),array('class'=>"pull-right muted",'target'=>'_blank'));?>
		
		<?php if(isset($showSource) && $showSource && isset($data->lesson->title)):?>
			<?php echo Chtml::link(Yii::t('app','源自').'&nbsp;'.$data->lesson->title."&nbsp;&nbsp;",array('lesson/view','id'=>$data->lessonId),array('class'=>'muted pull-right'));?>
		<?php endif;?>
		
		<div class="clearfix"></div>
		</div>
	</div>
</div>