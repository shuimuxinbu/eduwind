<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activeRule')); ?>:</b>
	<?php echo CHtml::encode($data->activeRule); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('displayRule')); ?>:</b>
	<?php echo CHtml::encode($data->displayRule); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />
<div class="pull-right">
<?php echo CHtml::ajaxLink('<i class="icon-trash"></i>删除',array('delete','id'=>$data->id),array('type'=>'post','success'=>'js:function(data){window.location.reload();}'),array('class'=>'ml10'));?>
<?php echo CHtml::link('<i class="icon-pencil"></i>编辑',array('update','id'=>$data->id),array('class'=>'ml10'));?>

</div>
<div class="clearfix"></div>
</div>