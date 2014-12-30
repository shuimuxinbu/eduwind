<div class="dxd-post-item">

<?php
 echo CHtml::link($data->title,
 				  array('group/post',
 				  		'id'=>$data->id),
 				  		array('class'=>'dxd-post-link')
 				  );
?>
<br />
<div>
<span  class="muted">
	by&nbsp;&nbsp;<?php echo CHtml::link($data->user->name,array('//u/index',
												'id'=>$data->user->id),array(
												'class'=>'muted dxd-name',
												'data-userId'=>$data->user->id
											));?>
</span>		
		<div class="pull-right">
	<?php
 $this->widget('booster.widgets.TbLabel', array(
    'type'=>'success', // 'success', 'warning', 'important', 'info' or 'inverse'
    'label'=>$data->commentNum,
)); 
?>
	</div>
	<div class="clearfix"></div>
</div>
</div>
