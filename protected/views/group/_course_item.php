<li class="col-sm-2 dxd-group-course-item" style="width:192px;" courseId="<?php echo $data->id;?>" >
  <div class="thumbnail ">
  		<div class="dxd-course-operate">

  		  		 <?php	
  		  		 //在我的课表之外显示
  		  		 echo CHtml::link(($data->isCollector(Yii::app()->user->id)?Yii::t('app','取消收藏'):Yii::t('app','收藏课程')),array(
					'course/toggleCollect','id'=>$data->id),array(
					'onclick'=>'toggleCollect(this);return false;',
					'class'=>'btn dxd-course-learn-btn  hidden-xs'
  		 			));
  		 			?>

	  </div>
  		<?php 
  		$imgUrl = ($data->face && DxdUtil::xImage($data->face,220,110)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($data->face,220,110) : "http://placehold.it/220x110"?>
	    <?php $image = CHtml::image($imgUrl,'image',array('style'=>'height:120px;width: 100%;','class'=>'hidden-xs'));
	    	echo CHtml::link($image,array('course/view','id'=>$data->id));?>
	    <div style="padding:10px;">
	    <div style="line-height:22px;font-size:16px;height:44px;">
	    <strong>
	    	<?php echo CHtml::link(mb_substr($data->name,0,32,'utf-8'),array('course/view','id'=>$data->id),array('style'=>"color:#333;"));?>
	    </strong></div>
	    <hr style="margin:10px 0;"/>
	    <table style="width: 100%">
	    <tr><td><?php  echo $data->rateNum?><?php echo Yii::t('app','人评价')?></td><td><?php echo Yii::t('app','学员')?></td></tr>
	    <tr>
	    	<td style="width:115px">
	    		<div style="width:80px;height:16px;" class="dxd-star-rating-<?php   echo intval(round($data->rateScore));?>"></div>
			</td>
			<td><i class="icon-user"></i>&nbsp;<?php echo $data->memberNum?></td>
		</tr>
	    </table>
    	</div>
    </div>
</li>
