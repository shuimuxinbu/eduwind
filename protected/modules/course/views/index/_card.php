<!--  
<li class="dxd-course-card-item" courseId="<?php echo $data->id;?>">
  <div class=" dxd-course-card">
  		<div class="dxd-course-operate">

  		  		 <?php	
  		  		 //在我的课表之外显示
  		  		 echo CHtml::link(($data->isCollector(Yii::app()->user->id)?Yii::t('app','取消收藏'):Yii::t('app','收藏课程')),array(
					'course/toggleCollect','id'=>$data->id),array(
					'onclick'=>'toggleCollect(this);return false;',
					'class'=>'btn dxd-course-learn-btn  hidden-phone'
  		 			));
  		 			?>

	  </div>
  		<?php 
  		$imgUrl = ($data->face && DxdUtil::xImage($data->face,240,160)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($data->face,240,160) : "http://placehold.it/220x110"?>
	    <?php $image = CHtml::image($imgUrl,'image',array('style'=>'height:150px;width: 100%;','class'=>'hidden-phone'));
	    	echo CHtml::link($image,array('//course/inde/view','id'=>$data->id));?>
	    <div style="padding:10px;border:1px solid #ccc;border-top:none;">
	    <div style="line-height:20px;font-size:16px;height:40px;"><?php echo CHtml::link(mb_substr($data->name,0,32,'utf-8'),array('view','id'=>$data->id),array('style'=>"color:#333;"));?></div>
	    <hr/>
	    <table style="width: 100%">
	    <tr><td><?php  echo $data->rateNum?>人评价</td><td>浏览</td><td>学员</td></tr>
	    <tr>
	    	<td style="width:115px">
	    		<div style="width:80px;height:16px;" class="dxd-star-rating-<?php   echo intval(round($data->rateScore));?>"></div>
			</td>
			<td><?php echo $data->viewNum?></td>
			<td><i class="icon-user"></i>&nbsp;<?php echo $data->memberNum?></td>
		</tr>
	    </table>
	    <hr/>
	    <?php $teachers = $data->getMemberDataProviderByRole('teacher');
	    foreach($teachers->getData() as $teacher):  ?>
        <div style="padding-bottom:5px;">by <?php echo CHtml::link($teacher->user->name,$teacher->user->pageUrl,array('style'=>'color:#111;','class'=>'dxd-username','data-userId'=>$teacher->user->id));?><span class="muted">&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d',$data->addTime);?></span></div>
    	<?php endforeach;?>
    	<?php if(empty($teacher)):?>
    	<div style="padding-bottom:5px;">by <?php echo CHtml::link($data->user->name,$data->user->pageUrl,array('style'=>'color:#111;','class'=>'dxd-username','data-userId'=>$data->user->id));?><span class="muted">&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d',$data->addTime);?></span></div>
    	<?php endif;?>
    	</div>
    </div>
</li>
-->
<li class="col-sm-2" style="width:230px;margin-left:20px;" courseId="<?php echo $data->id;?>" >
  <div class="thumbnail ">
  		<div class="dxd-course-operate">

  		  		 <?php	
  		  		 //在我的课表之外显示
  		  		 echo CHtml::link(($data->isCollector(Yii::app()->user->id)?Yii::t('app','取消收藏'):Yii::t('app','收藏课程')),array(
					'toggleCollect','id'=>$data->id),array(
					'onclick'=>'toggleCollect(this);return false;',
					'class'=>'btn dxd-course-learn-btn  hidden-phone'
  		 			));
  		 			?>

	  </div>
  		<?php 
  		$imgUrl = ($data->face && DxdUtil::xImage($data->face,240,160)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($data->face,240,160) : "http://placehold.it/220x110"?>
	    <?php $image = CHtml::image($imgUrl,'image',array('style'=>'height:120px;width: 100%;','class'=>'hidden-phone'));
	    	echo CHtml::link($image,array('view','id'=>$data->id));?>
	    <div style="padding:10px;">
	    <div style="line-height:24px;font-size:18px;height:50px;">
	    <strong>
	    	<?php echo CHtml::link(mb_substr($data->name,0,32,'utf-8'),array('view','id'=>$data->id),array('style'=>"color:#333;"));?>
	    </strong></div>
	    <hr style="margin:10px 0;"/>
	    <table style="width: 100%">
	    <tr><td><?php  echo Yii::t('app','{rateNum}人评价',array("{rateNum}"=>$data->rateNum));?></td><td><?php echo Yii::t('app','浏览');?></td><td><?php echo Yii::t('app','学员');?></td></tr>
	    <tr>
	    	<td style="width:115px">
	    		<div style="width:80px;height:16px;" class="dxd-star-rating-<?php   echo intval(round($data->rateScore));?>"></div>
			</td>
			<td><?php echo $data->viewNum?></td>
			<td><i class="icon-user"></i>&nbsp;<?php echo $data->memberNum?></td>
		</tr>
	    </table>
	    <hr style="margin:10px 0"/>
	    <?php $teachers = $data->getMemberDataProviderByRole('teacher');
	    foreach($teachers->getData() as $teacher):  ?>
        <div style="padding-bottom:0px;">by <?php echo CHtml::link($teacher->user->name,$teacher->user->pageUrl,array('style'=>'color:#111;','class'=>'dxd-username','data-userId'=>$teacher->user->id));?><span class="muted">&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d',$data->addTime);?></span></div>
    	<?php endforeach;?>
    	<?php if(empty($teacher)):?>
    	<div style="padding-bottom:0px;">by <?php echo CHtml::link($data->user->name,$data->user->pageUrl,array('style'=>'color:#111;','class'=>'dxd-username','data-userId'=>$data->user->id));?><span class="muted">&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d',$data->addTime);?></span></div>
    	<?php endif;?>
    	</div>
    </div>
</li>
