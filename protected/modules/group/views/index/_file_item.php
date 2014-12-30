<div  class="dxd-dashed-bottom-border dxd-hover-show-container" style="padding:10px 0"> 

<?php 
if(Yii::app()->user->id==$data->userId){
	echo CHtml::link("<i class='icon-remove' ></i>",array('courseFile/delete','id'=>$data->fileid),array('class'=>'pull-right dxd-hover-show','title'=>Yii::t('app','删除'),'onclick'=>'deleteCourseFile(this);return false;'));
}
$img = CHtml::image(Yii::app()->baseUrl.DxdUtil::getIconByExt($data->name));
echo CHtml::link($img."  ".$data->name,array('courseFile/down','id'=>$data->fileid),array('style'=>'vertical-align:bottom'));
?>
<span class="muted pull-right" style="font-size:0.8em;"><?php echo Yii::t('app','下载')?>&nbsp;<?php echo $data->count_down;?>&nbsp;&nbsp;</span>
<div class="clearfix"></div>
</div>