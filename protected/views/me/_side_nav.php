<?php $user=UserInfo::model()->findByPk(Yii::app()->user->id);?>
<div style="border-right:1px solid #ccc;padding-bottom:20px;">
<div style="padding:20px;">
	<div class="dxd-user-face center">
	<?php echo CHtml::image(Yii::app()->baseUrl."/".$user->face,$user->name,array('class'=>'dxd-user-face-large center','style'=>'width:130px;height:130px;display:block;'))?>
	<?php // echo CHtml::link('设置个人头像',array('me/setFace','id'=>$user->id),array('class'=>'dxd-set-user-face dxd-fancy-elem'));?>
	</div>
	<div style="text-align: center;font-size:1.6em;padding-top:10px;;"><?php echo $user->name;?></div>
</div>
<?php
	$this->widget('booster.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
//				   array('label'=>'我的课表','icon'=>'home','url'=>array('me/index')),
				//   array('label'=>'最新动态','icon'=>'leaf','url'=>array('feed/index')),
//				   array('label'=>'课堂笔记','icon'=>'edit','url'=>array('lesson/myNotesIndex')),
				   array('label'=>Yii::t('app','提醒'),'icon'=>'bell','url'=>array('notice/index')),
				   array('label'=>Yii::t('app','私信'),'icon'=>'envelope','url'=>array('message/index')),
//				   array('label'=>'关注/粉丝','icon'=>'user','url'=>"#"),
//				   array('label'=>'邮件联系人','icon'=>'star','url'=>array('contact/index')),
				   array('label'=>Yii::t('app','设置'),'icon'=>'cog','url'=>array('me/setBasic'))
				),
	));
?>
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
