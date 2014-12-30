<li class="dxd-group-card-item" groupid="<?php echo $data->id;?>">
  <div class="thumbnail dxd-group-card">
  	<table style="width:100%">
  	<tr>
  	<td style="width:70px;vertical-align:top">
  		<?php $imgUrl = ($data->face && DxdUtil::xImage($data->face,60,60)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($data->face,60,60) : "http://placehold.it/60x60"?>
	    <?php $image = CHtml::image($imgUrl,'image',array('style'=>'width:60px;height:60px;','class'=>' '));
	    	echo CHtml::link($image,array('view','id'=>$data->id));?>
	</td>
	<td style="vertical-align:top">
	<div style="margin-bottom:5px">
	    <?php echo CHtml::link($data->name,array('view','id'=>$data->id));?>
		&nbsp;&nbsp;<span class="muted"><?php echo Yii::t('app','{count} 成员',array("{count}"=>$data->memberCount)</span>
</div>
	    <div>
	    <?php echo mb_substr(strip_tags($data->introduction),0,50,'utf8')."...";?>
	    </div>
   </td>
   </tr>
   </table>
  </div>
</li>