<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>



<?php 
Yii::app()->bootstrap->register();

?>
 
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style.min.css?v=131108" />


</head>

<body>

<?php $this->widget('booster.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    'brand'=>"EduWind"."<sup style=\"font-size:0.6em\">".Yii::t('app','开源在线教育社区')."</sup>",
//    'brandUrl'=>Yii::app()->baseUrl,
 //   'collapse'=>true, // requires bootstrap-responsive.css
    'fixed'=>false,
	'htmlOptions'=>array('style'=>'margin-bottom:0;'),
    'items'=>array(
  
    ),
)); ?>
<?php $this->renderPartial('//layouts/_flash_messages');?>
<br/><br/>

	<?php echo $content; ?>

	<div class="clearfix"></div>
<br/>
<div class="container">

	<div id="footer">
	
		Powered by <strong><?php echo CHtml::link("EduWind","http://www.eduwind.me");?></strong>&nbsp;&nbsp;<?php echo Yii::app()->params['settings']['site']['icp'];?>&nbsp;&nbsp;&nbsp;
	    Copyright &copy; <?php echo "2013-".date('Y'); ?>
	</div><!-- footer -->

</div><!-- page -->
</body>
</html>
