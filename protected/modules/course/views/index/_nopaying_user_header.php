<?php 
$this->pageTitle = Yii::app()->name."-$course->name";
?>
<div class="dxd-course-header">	
	<div class="dxd-course-nav" style="border-top:none;padding-top:15px;padding-bottom:15px;">
		
		<div class="dxd-course-header-left1">
		
		<?php $imgUrl = ($course->face && DxdUtil::xImage($course->face,350,260)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($course->face,350,260) : "http://placehold.it/350x260"?>
		<?php echo CHtml::image($imgUrl,'image',array('class'=>'pull-left','style'=>'width:350px;height:260px;'));?>
		</div>
		<div class="dxd-course-header-left2" style="text-align:center;padding:20px 20px 0 20px;">
			<?php // echo $this->renderPartial('_topic', array('course'=>$course));?>

			
			<h1 ><?php echo $course->name;?></h1>
			<p style="font-size:18px;margin:15px;"><?php echo $course->subTitle;?></p>
			<div>
				
				<?php 
					global $sysSettings;
					if(isset($sysSettings['payment']['means']) && $sysSettings['payment']['means']=="stripe"){
						Yii::import('ext.stripe.MStripe');
						$this->widget('ext.stripe.MStripe',array('secretKey'=>$sysSettings['payment']['stripeSecretKey'],
																 'publishableKey'=>$sysSettings['payment']['stripeSecretKey'],
																 'amount'=>$course->fee,
																	'chargeUrl'=>$this->createUrl('buy',array('id'=>$course->id))));
					}else{
						echo CHtml::link(Yii::t('app','选修课程').'&nbsp;&nbsp; <span class="badge badge-info course-price" style="top:1px;">￥'.$course->fee.'</span>',array('buy','id'=>$course->id),array('class'=>'btn btn-large btn-warning btn-course-pay'));
					}
					?>
			</div>
		</div>
		<div class="dxd-course-header-right pull-right" style="padding-right:15px;margin-top:30px;">
		<?php 
			if(!Yii::app()->user->isGuest){
			echo CHtml::link(($course->isCollector(Yii::app()->user->id)?Yii::t('app','取消收藏'):Yii::t('app','收藏课程')),array(
					'toggleCollect','id'=>$course->id),array(
					'onclick'=>'toggleCollect(this);return false;',
					'style'=>'margin-left:25px;padding-top:2px;' ));
			}
		?>
		</div>


<div class="clearfix"></div>

		</div>

<div class="clearfix"></div>
	</div>
  


<?php 
/*
$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target'=>'.dxd-fancy-elem',
    'config'=>array(
		'type'=>'iframe',
		'hideOnOverlayClick'=>false,
        'maxWidth'    => 500,
        'maxHeight'   => 300,
        'fitToView'   => false,
        'autoSize'    => true,
        'closeClick'  => false,
        'openEffect'  => 'none',
        'closeEffect' => 'none',
		'onClosed'=>'js:function(){window.location.reload();}'
    ),
));*/
?>