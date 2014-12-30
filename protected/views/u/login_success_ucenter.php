<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php 
echo $script; 
?>
<script type="text/javascript">setTimeout('location.href="<?php echo Yii::app()->user->returnUrl ?>"',1000);</script>
<?php echo Yii::t('app','登录成功，正在返回登录前页面...')?>
</body>
</html>
