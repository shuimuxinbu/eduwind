<div>
	<div>
	<?php $imgUrl =  DxdUtil::xImage($data->user->face,60,60) ?  Yii::app()->baseUrl."/".DxdUtil::xImage($data->user->face,60,60) :"http://placehold.it/60x60";?>
	<?php echo CHtml::image($imgUrl,'image',array('class'=>' pull-left dxd-username img-circle','data-userid'=>$data->userId,'style'=>'width:60px;height:60px'));?>
	</div>
	<div class="pull-left " style="padding-left:15px;">
	<p  style="font-size: 1.2em;margin:5px 0;">
		<?php echo CHtml::link($data->user->name,$data->user->pageUrl,array('class'=>'dxd-username text-warning','data-userid'=>$data->userId));?></p>
	<?php echo mb_substr($data->user->bio, 0, 16, 'utf-8'); ?>
	</div>
	<div class="clearfix"></div>
	<div style="padding-top:10px">
	<?php echo $data->user->introduction;?>
	</div>
</div>


