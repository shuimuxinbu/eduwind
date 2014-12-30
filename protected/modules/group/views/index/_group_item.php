<li class="col-sm-2" courseId="<?php echo $data->id;?>" style="background-color:#ececec" >
	<div class="group-card" style="margin-bottom:20px">
  		<div style="margin:10px 10px 15px 10px;">
		<?php 
  		$imgUrl = ($data->face && DxdUtil::xImage($data->face,150,150)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($data->face,150,150) : "http://placehold.it/150x150"?>
	    <?php $image = CHtml::image($imgUrl,'image',array('style'=>'width: 150px;height:150px;','class'=>'hidden-phone'));
	    	echo CHtml::link($image,array('//group/index/view','id'=>$data->id));?>
	    	</div>
	   <div class="text-center">
	    	<?php //echo CHtml::link(mb_substr($data->name,0,32,'utf-8'),array('//course/index/view','id'=>$data->id),array('style'=>""));?>
	   		<div  style="font-size:20px"><?php echo CHtml::link(mb_substr($data->name,0,12,'utf-8'),array('//group/index/view','id'=>$data->id),array('style'=>'color:#555;'));?></div>
	   		<div class="muted"><small>			<?php echo $data->memberNum;?>&nbsp;<?php echo Yii::t('app','成员');?></small>
	   		</div>
	   		<div style="margin-top:20px">
	    	<?php echo CHtml::link(Yii::t('app','+ 加入小组'),array('view','id'=>$data->id),array('class'=>'group-card-join light-green'));?>
	   		</div>
	    </div>
    	</div>
</li>
