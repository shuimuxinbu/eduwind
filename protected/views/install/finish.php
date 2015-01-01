<?php
?>
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
	<div class="well">
	<?php
$this->renderPartial('_header');
?>		<br/>
<div>
<p>安装成功！为安全起见，请删除protected/controllers/InstallController.php文件</p>
<p>你现在可以
<?php echo CHtml::link('用管理员账户登陆',array('/u/login'),array('class'=>'btn btn-primary'));?>
 或
<?php echo CHtml::link('去首页看看',Yii::app()->baseUrl,array('class'=>'btn'));?>
</p>
</div>
	</div>
</div>
</div>
