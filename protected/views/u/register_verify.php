<?php
/* @var $this UserController */
/* @var $model UserInfo */

?>

<h2><?php echo Yii::t('app','查收确认邮件')?></h2>
<hr/>
	<?php if(isset($success) && $success):?>
	<div class="col-sm-2 center" style="margin-top:200px;">
		<div style="font-size:16px;padding-bottom:30px;"><?php echo Yii::t('app','验证成功！')?>&nbsp;&nbsp;
		<?php echo CHtml::link(Yii::t('app',"去登录"),array('u/login'),array('class'=>'btn btn-success'));?>
		</div>
	</div>
	<?php else:?>
<div class="col-sm-6 center">

	<div style="font-size:16px;padding-bottom:30px;"><?php echo Yii::t('app','我们已经向你的邮箱');?>&nbsp;<em><?php echo $user->email;?></em>&nbsp;<?php echo Yii::t('app','发送了一封确认邮件，你需要点击确认邮件来完成注册。')?></div>
	<div style="font-size:16px;"><?php echo Yii::t('app','没有收到邮件？')?></div>
	<div style="color:gray;padding-left:20px;padding-top:15px;">
		<?php echo Yii::t('app','检查是否在邮箱的垃圾箱里')?><br/>
		<?php echo Yii::t('app','稍等几分钟，如果还是没有收到，点击')?>&nbsp;&nbsp;<?php echo CHtml::link(Yii::t('app',"重新发送"),array('u/verify','email'=>urlencode($user->email)),array('class'=>'btn btn-success'));?>
	</div>
</div>
	<?php endif;?>

<br/><br/><br/>
