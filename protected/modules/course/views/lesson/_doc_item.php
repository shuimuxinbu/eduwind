<div  class="dxd-hover-show-container"> 
	<?php 	if(isset($data->file->name)):?>
	<?php 
		$img = CHtml::image(Yii::app()->baseUrl.DxdUtil::getIconByExt($data->file->name));
		echo CHtml::link($img."&nbsp;&nbsp;".$data->file->name,array('lessonDoc/download','id'=>$data->id),array('style'=>''));
	?>

	<div class="mt10">
	<?php  echo $data->description;?>
	</div>
	<?php endif;?>
</div>