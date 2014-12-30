<?php
/* @var $this LessonController */
/* @var $data Lesson */
?>


<div>
	<?php echo CHtml::image(($data->user->face && DxdUtil::xImage($data->user->face,40,40)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($data->user->face,40,40) : "http://placehold.it/40x40",'image',array('style'=>'width:40px;height:40px;','class'=>'pull-left'));?>
	<div style="margin-left:50px">
	<?php echo CHtml::link($data->user->name,$data->user->pageUrl);?>
	&nbsp;&nbsp;<span class="muted">
		<?php echo date('Y-m-d H:i',$data->addTime);?></span>
	<div>
	<?php echo $data->content;?>
	</div>
	<div>
		<?php echo CHtml::link(Yii::t('app','回答'),'javascript:;',array('class'=>'muted pull-right','data-toggle'=>'collapse','data-target'=>'#dxd-comment-form-'.$index));?>
		<div class="clearfix"></div>
	</div>
	<div id="dxd-comment-form-<?php echo $index;?>" class="collapse">
		<?php $this->renderPartial('/lesson/_comment_form',array('comment'=>$data,'lesson'=>$lesson));?>
	</div>
	<?php 
	if($data->refer){ ?>
	<div class="muted" style="border-left:1px solid #ccc;padding:10px;">
		<?php echo CHtml::link($data->refer->user->name,$data->refer->user->pageUrl);?>:
		<?php  echo mb_strlen($data->refer->content,'utf-8')>140 ? mb_substr($data->refer->content,0,140,'utf-8')."..." : $data->refer->content?>
	</div>
	<?php }?>
</div>
</div>