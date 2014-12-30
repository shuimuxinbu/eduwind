<div class="dxd-course-header">	
	<div class="dxd-course-nav" style="border-top:none;padding-top:15px;padding-bottom:15px;">
		
		<div class="dxd-course-header-left1">
		<?php $imgUrl = ($group->face && DxdUtil::xImage($group->face,100,100)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($group->face,100,100) : "http://placehold.it/100x100"?>
		<?php echo CHtml::image($imgUrl,'image',array('class'=>'pull-left dxd-group-face'));?>
		<?php //echo CHtml::link('设置头像',array('group/setFace','id'=>$group->id),array('class'=>'dxd-set-course-face dxd-set-group-face dxd-fancy-elem'));?>
		</div>
		<div class="pull-left dxd-course-header-left2">
			<?php  //echo $this->renderPartial('_tag', array('group'=>$group));?>
			<?php /* $this->widget('application.extensions.TagWidget.TagWidget',
							array(
									'tagNamesString'=>$group->getTagNamesString(),
									'allTagNamesString'=>Tag::getTagNamesString(),
									'callBackUrl'=>Yii::app()->createUrl('group/updateMark',array('id'=>$group->id)),
									'historyUrl'=>array('revisionHistory/coursetopic','courseId'=>$group->id),
									'allowEdit'=>(!Yii::app()->user->isGuest),
							)
					); */?>
			
			<h1><?php echo $group->name;?></h1>
		</div>
		
		<div class="pull-right dxd-course-header-right">

		<?php  
				$this->renderPartial('_join',array('member'=>$member,'group'=>$group));			
		?>
				<div style="margin-top:5px;"class="pull-right"><? echo Yii::t('app','创建者：')?><?php echo CHtml::link($group->superAdmin->name,array('//u/index','id'=>$group->superAdmin->id))?>&nbsp;&nbsp;&nbsp;<?php echo Yii('app','成员')?>&nbsp;<?php echo Yii::t('app','{memberNum}人',array('{memberNum}'=>$group->memberNum))?>&nbsp;&nbsp;
		</div>
		</div>

<div class="clearfix"></div>

		</div>
		 
	</div>
  


<?php 
/*
$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target'=>'.dxd-fancy-elem',
    'config'=>array(
		'type'=>'iframe',
		'hideOnOverlayClick'=>false,
        'maxWidth'    => 500,
        'maxHeight'   => 200,
        'fitToView'   => false,
        'autoSize'    => true,
        'closeClick'  => false,
        'openEffect'  => 'none',
        'closeEffect' => 'none',
		'onClosed'=>'js:function(){window.location.reload();}'
    ),
));*/
?>