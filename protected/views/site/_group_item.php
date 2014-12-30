<li class="col-sm-4" >
<div class="thumbnail" style="display:inline-block;margin-bottom:15px;vertical-align:top;border:none;box-shadow:none;"  data-groupid="<?php echo $data->id;?>">
  	<table style="width:100%">
  	<tr>
  	<td style="width:115px;vertical-align:top">
  		<?php $imgUrl = ($data->face && DxdUtil::xImage($data->face,100,100)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($data->face,100,100) : "http://placehold.it/100x100"?>
	    <?php $image = CHtml::image($imgUrl,'image',array('style'=>'width:100px;height:100px;','class'=>' '));
	    	echo CHtml::link($image,array('group/index/view','id'=>$data->id));?>
	</td>
	<td style="padding-right:15px;vertical-align:top">
	<div style="margin-bottom:5px;">
	    <?php echo CHtml::link($data->name,array('group/index/view','id'=>$data->id),array('style'=>'font-size:1.5em;'));?>
		&nbsp;&nbsp;<span class="muted"><?php echo Yii::t('app','{memberNum}成员',array('{memberNum}'=>$data->memberNum));?></span>
	</div>
	    <div>
	    <?php echo mb_substr(strip_tags($data->introduction),0,50,'utf8')."...";?>
	    </div>
   </td>
   </tr>
   </table>
</div>
</li>
