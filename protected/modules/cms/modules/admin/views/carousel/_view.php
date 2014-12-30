<?php
/* @var $this CarouselController */
/* @var $data Carousel */
?>

<div class="view" style="border:1px solid #ccc;padding:15px;margin-bottom:20px;">


	<b><?php echo CHtml::encode($data->getAttributeLabel('path')); ?>:</b>
	<?php echo '<img src="'.Yii::app()->baseUrl."/".$data->path.'" style="width:230px;height:100px;"/>'; //thumbnail
		//echo '<img src="'.$data->attachment.'" />'; //base image 
	?>
	<br />
<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br /><br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('courseId')); ?>:</b>
	<?php if($data->course) echo CHtml::encode($data->course->name); ?>
	<?php echo CHtml::link('修改',array('update','id'=>$data->id),array('class'=>'pull-right ml10'));?>
&nbsp;&nbsp;
	<?php echo CHtml::link('删除',array('delete','id'=>$data->id),array('class'=>'pull-right'));?>
	<div class="clearfix"></div>

</div>