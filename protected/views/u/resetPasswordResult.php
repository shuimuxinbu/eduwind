<?php
/* @var $this UserController */
/* @var $model UserInfo */

?>

<h2><?php echo Yii::t('app','重新设置密码');?></h2>
<hr/>
<div class="row">
	<div class="col-sm-4 center" style="margin-top:20px;">
		<?php if($result):?>
			<div><?php echo Yii::t('app','设置成功！')?>&nbsp;&nbsp;
						<?php echo CHtml::link(Yii::t('app','去登录'),array('u/login'));?>
			</div>
		<?php else:?>
			<div><?php echo Yii::t('app','抱歉，设置失败...')?>&nbsp;&nbsp;
			<?php echo CHtml::link(Yii::t('app','再试一次'),array('u/forgetPassword'));?>
			</div>
		<?php endif;?>
	</div>
</div>

