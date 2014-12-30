<?php
/* @var $this MessageController */
/* @var $model Message */
?>

<h3 class="dxd-fancybox-header"><?php echo Yii::t('app','课程续费');?></h3>
<div class="dxd-fancybox-body">

	<div style=""><span style=""><span class="text-error"><?php echo Yii::t('app',"小提示：")?></span><?php echo <?php echo Yii::t('app','你已过课程有效期，需要重新续费才能加入学习');?><br/>
	<?php echo <?php echo Yii::t('app','续费价格：');?>￥</span><span class="text-success"><?php echo Yii::t('app','{renewFee}元',array("{renewFee}"=>$course->renewFee));?></span></div>


</div>

<div class="dxd-fancybox-footer">

	<div class="mt20">
		<?php echo CHtml::link(Yii::t('app','去续费'),array('rebuy','id'=>$course->id),array('class'=>'pull-right btn btn-success'));?>
	</div>
	<div class="clearfix"></div>
</div>
