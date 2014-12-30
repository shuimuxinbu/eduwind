<div class="dxd-post-item">

<?php
 echo CHtml::link($data->title,
 				  array('post/view',
 				  		'id'=>$data->id),
 				  		array('class'=>'dxd-post-link')
 				  );
?>
<br />
<div  class="muted">
	by&nbsp;&nbsp;<?php echo CHtml::link($data->user->name,$data->user->pageUrl,array(
												'class'=>'muted dxd-username',
												'data-userId'=>$data->user->id
											));?>
		&nbsp;&nbsp;&nbsp;<span><?php echo date('Y-m-d')?></span>

	<div class="pull-right">
	<?php $this->widget('booster.widgets.TbBadge', array(
//	    'type'=>'success', // 'success', 'warning', 'important', 'info' or 'inverse'
	    'label'=>$data->commentCount,
	)); ?>
	</div>
</div>
</div>
