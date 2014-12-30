<div class="dxd-course-header">
	<div class="dxd-course-nav" style="border-top:none;padding-top:15px;padding-bottom:15px;">

		<div class="dxd-course-header-left1">

		<?php $imgUrl = ($course->face && DxdUtil::xImage($course->face,160,120)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($course->face,160,120) : "http://placehold.it/200x150"?>
		<?php echo CHtml::image($imgUrl,'image',array('class'=>'pull-left dxd-course-face','style'=>'width:160px;height:120px;'));?>
		<?php //echo CHtml::link('设置课程封面图片',array('course/setFace','id'=>$course->id),array('class'=>'dxd-set-course-face dxd-fancy-elem'));?>
		</div>
		<div class="pull-left dxd-course-header-left2">
			<?php // echo $this->renderPartial('_topic', array('course'=>$course));?>


			<h1><?php echo $course->name;?></h1>
			<div style="line-heigh:16px;">
						<div style="width:80px;height:16px;display:inline-block;vertical-align:-2px;" class="dxd-star-rating-<?php echo intval(round($course->rateScore));?>"></div>
			&nbsp;<?php echo round($course->rateScore,1);?><?php echo Yii::t('app','分')?>
			&nbsp;&nbsp;&nbsp;<?php echo CHtml::link(Yii::t('app','({rateNum}条评价)',array("{rateNum}"=>$course->rateNum)),array('rates','id'=>$course->id),array('class'=>'dxd-fancy-elem','data-boxHeight'=>"800"));?>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if(! $course->hasRated(Yii::app()->user->id,$course->id)) echo CHtml::link(Yii::t('app','我要评价'),array('toggleRate','id'=>$course->id),array('class'=>'dxd-fancy-elem'));?>

				<div style="margin-top:7px;"class=" muted">by <?php echo CHtml::link($course->user->name,$course->user->pageUrl,array('class'=>'muted dxd-username','data-userId'=>$course->user->id))?>&nbsp;&nbsp;
				</div>
				<div class="clearfix"></div>
		</div>
		</div>

		<div class="pull-right dxd-course-header-right" style="text-align:right">

			<div class="btn-toolbar">
			    <?php $this->widget('booster.widgets.TbButtonGroup', array(
			       // 'context'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			        'buttons'=>array(
			   		    array('label'=>Yii::t('app','收藏'), 'url'=>'#'),
			            array('items'=>array(
			                array('label'=>($course->isCollector(Yii::app()->user->id)?Yii::t('app','取消个人收藏'):Yii::t('app',"个人收藏")), 'url'=>array('index/toggleCollect','id'=>$course->id)),
			                array('label'=>Yii::t('app','小组收藏'), 'url'=>array('//group/course/myGroup','courseId'=>$course->id),'linkOptions'=>array('class'=>'dxd-fancy-elem')),
			            ),
			             'htmlOptions'=>array('class'=>'mr15')
			            ),
			            array('label'=>Yii::t('app','课程管理'),
			            'url'=>array('manage/index/setBasic','id'=>$course->id),
			            'visible'=>(Yii::app()->user->checkAccess('admin') || $member->inRoles(array('superAdmin','admin'))),
			            'htmlOptions'=>array('class'=>'mr15')
			            )
			        ),
			    )); ?>
			</div>
			<div class="mr15" style="margin-top:80px">
				<?php
					if(!(Yii::app()->user->checkAccess('admin')) && !($member->inRoles(array('superAdmin','admin'))) && $member && !$member->isValid()):?>
						<span class="text-error"><?php echo Yii::t('app','已过有效期')?>，<?php echo CHtml::link(Yii::t('app','点击续费').'￥'.$course->renewFee,array('rebuy','id'=>$course->id),array('class'=>'text-error'));?></span>
				<?php endif;?>
			</div>

			<?php
				//echo CHtml::link($course->isCollector(Yii::app()->user->id)?'取消收藏':"收藏",array('course/toggleCollect','id'=>$course->id),array('class'=>'btn mr10','onclick'=>'toggleCollect(this);return false;'));


			?>
			<?php
			//echo CHtml::link('关联小组',array('groupCourse/create','courseId'=>$course->id),array('class'=>'pull-right btn','style'=>"margin-left:10px",'onclick'=>'openFancyBox(this);return false;'));
			?>

			<?php
			//$role = $course->lookUpRole(Yii::app()->user->id);
		//	if(Yii::app()->user->checkAccess('admin') || $member->inRoles(array('superAdmin','admin')))
		//		echo CHtml::link('课程管理',array('/courseAdmin/course/setBasic','id'=>$course->id),array('class'=>'btn mr10'));
			?>


		</div>

<div class="clearfix"></div>

		</div>

<div class="clearfix"></div>

	</div>

  <?php $this->widget('booster.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>Yii::t('app','主页'), 'url'=>array('/course/index/view','id'=>$course->id)),
        array('label'=>Yii::t('app','讨论区'), 'url'=>array('/course/post/index','courseId'=>$course->id)),
        array('label'=>Yii::t('app','进度'), 'url'=>array('/course/index/progress','id'=>$course->id)),
    ),
    'htmlOptions'=>array('class'=>'group-post-tabs'),
)); ?>
<!--
<div class="row menu">
    <?php
/*        $action = $this->action->id;
        $view = $course = $member = '';
        $action = 'active';
        echo CHtml::link('主页', 'id'=>$course->id));
        echo CHtml::link('讨论区',"#");
        echo CHtml::link('课程介绍', "#");*/
    ?>
</div>
-->
<?php
/*$this->widget('application.extensions.fancybox.EFancyBox', array(
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
