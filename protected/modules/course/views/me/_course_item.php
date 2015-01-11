<div class="col-sm-4" courseId="<?php echo $data->id;?>" >
<div class="course-card">
  		<?php
  		$imgUrl = ($data->face && DxdUtil::xImage($data->face,270,200)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($data->face,270,200) : "http://placehold.it/270x200"?>
	    <?php $image = CHtml::image($imgUrl,'image',array('style'=>'width:100%;height:200px;','class'=>'hidden-xs'));
	    	echo CHtml::link($image,array('//course/index/view','id'=>$data->id));?>
	    <div style="border:2px solid #eee;border-top:none;">
	    	<?php echo CHtml::link(mb_substr($data->name,0,32,'utf-8'),array('//course/index/view','id'=>$data->id),array('style'=>"display:block;color:#333;font-size:22px;height:50px;border-bottom:2px solid #eee;padding:25px;line-height:30px;"));?>
			<div style="padding:18px 25px">
			<div  class="pull-left">
				<?php if($data->fee==0):?>
				<strong class="orange-color"><?php echo Yii::t('app','免费');?></strong>
				<?php else:?>
					￥<strong class="orange-color"><?php echo $data->fee;?></strong>
				<?php endif;?>
			</div>
			<div class="pull-right muted">
			<?php echo Yii::t('app','已有 {count} 同学',array("{count}"=>$data->memberNum));?>
			</div>
			<div class="clearfix"></div>
    	</div>
    	</div>
    	</div>
</div>
