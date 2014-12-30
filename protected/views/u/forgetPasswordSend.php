<?php
/* @var $this UserController */
/* @var $model UserInfo */

?>

<h2><?php echo Yii::t('app','邮箱找回密码')?></h2>
<hr/>
<div class="row">
	<div class="col-sm-6 center" style="margin-top:20px;">
		<?php echo Yii::t('app','系统已经向邮箱{email}发去一封密码重设邮件，请注意查收。',array("{email}"=>$user->email));?>
	</div>

	
</div>

