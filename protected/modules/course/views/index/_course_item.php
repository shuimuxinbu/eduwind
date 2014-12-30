<div class="col-sm-3" courseId="<?php echo $data->id;?>" >
<div class="course-card">
  		<?php
  		$imgUrl = ($data->face && DxdUtil::xImage($data->face,270,200)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($data->face,270,200) : "http://placehold.it/270x200"?>
	    <?php $image = CHtml::image($imgUrl,'image',array('style'=>'width:100%; height:200px;','class'=>'hidden-phone'));
	    	echo CHtml::link($image,array('//course/index/view','id'=>$data->id));?>
	    <div style="border:2px solid #eee;">
	    	<?php echo CHtml::link(mb_substr($data->name,0,32,'utf-8'),array('//course/index/view','id'=>$data->id),array('style'=>"display:block;color:#333;font-size:22px;height:112px;border-bottom:2px solid #eee;padding:25px;line-height:30px;"));?>
			<div style="padding:18px 25px">
			<div  class="pull-left">
				<?php if($data->fee==0):?>
				<strong class="orange-color"><?php echo Yii::t('app','免费');?></strong>
				<?php else:?>
					￥<strong class="orange-color"><?php echo $data->fee;?></strong>
				<?php endif;?>
			</div>
			<div class="pull-right muted">
			<?php echo Yii::t('app','已有 {studentNum} 同学',array("{studentNum}"=>$data->studentNum));?>
			</div>
			<div class="clearfix"></div>
    	</div>
    	</div>
    	</div>
</div>
