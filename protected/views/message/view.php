<?php
/* @var $this MessageController */
/* @var $model Message */


?>

<div class="row">
	<div class="col-sm-2">
		<?php $this->renderPartial("/me/_side_nav");?>
	</div>
	<div class="col-sm-10">
		<h3 class="side-lined"><?php echo Yii::t('app','与'); echo CHtml::link($user->name,$user->pageUrl); echo Yii::t('app','的会话')?></h3>
		<?php echo CHtml::link('<i class="icon-chevron-left"></i>'.Yii::t('app','返回信箱'),array('message/index'),array('class'=>'btn btn-default'));?>
				<?php
		 $this->widget('booster.widgets.TbButton', array(
   		'label'=>'<i class="icon-envelope"></i>'.Yii::t('app','写私信'),
   	 	'url'=>array('message/create','toUserId'=>$user->id),
		'htmlOptions'=>array('style'=>'margin:0 5px;','class'=>"dxd-message-btn",'onclick'=>'openFancyBox(this);return false;'),
		'encodeLabel'=>false,
		 ));
//	echo CHtml::ajaxLink('私信',array('message/create','toUserId'=>$user->id),array('update'=>'#fancybox-tmp','complete'=>'fancyAfterAjax'),array('class'=>'btn btn-small'));
	?>
		<?php $this->widget('booster.widgets.TbListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view',
			'separator'=>'<hr/>'
		)); ?>
		</div>
</div>

