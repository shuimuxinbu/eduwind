<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
$this->layout = 'none';
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url:"http://localhost/phpems/index.php?user-app-logout"
        });
        setTimeout('location.href="<?php echo Yii::app()->homeUrl ?>"', 2000);
    });
</script>
<?php echo Yii::t('app','退出成功，正在返回首页...');?>
</body>
</html>
