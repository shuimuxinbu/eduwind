<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="zh-CN" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.iframe-auto-height.plugin.min.js?v=131107"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/function.js"></script>
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/style.min.css">
</head>

<body>
<?php $this->widget('booster.widgets.TbNavbar', array(
    'brand'=>"EduWind 后台管理",
    'brandUrl'=>Yii::app()->createUrl("admin"),
    'collapse'=>true, // requires bootstrap-responsive.css
	'fixed'=>false,
	'items'=>array(
		array( 'class'=>'booster.widgets.TbMenu',
                'type'  =>  'navbar',
				'id'=>'main-nav',
            //'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>'课程','url'=>array('/course/admin/index')),
                array('label'=>'小组','url'=>array('/group/admin/index')),
                array('label'=>'内容','url'=>array('//cms/admin/nav/index')),
        //        array('label'=>'用户','url'=>array('user/admin')),
                array('label'=>'系统','url'=>array('//admin/setting/site')),

                 )),
        array(
            'class'=>'booster.widgets.TbMenu',
                'type'  =>  'navbar',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>'返回前台','url'=>Yii::app()->baseUrl.'/'),
                array('label'=>'管理员：'.Yii::app()->user->displayName, 'url'=>'#','visible'=>!Yii::app()->user->isGuest),
            ),
        ),
    ),
)); ?>
<?php $this->renderPartial('//layouts/_flash_messages');?>

<div style="overflow: hidden;
position: absolute;
z-index: 3;
top: 50px;
width: 100%;
bottom: 0px;">
	<iframe id="main-iframe" src="<?php echo $this->createUrl('setting/site');?>"
 	width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow: scroll;margin:0;padding:0;">
	</iframe>

<?php //echo $content; ?>
<script type="text/javascript">
$('#main-nav li a').click(function(){
//	$('#main-nav li').removeClass('active');
//	$(this).parent('li').addClass('active');
	$('#main-iframe').attr('src',$(this).attr('href'));
	return false;
});
</script>
	<div class="clear"></div>

	<div id="footer">
	<?php $this->widget('ext.hoverCard.HoverCard',array('target'=>'.dxd-name,.dxd-userface','config'=>array('url'=>Yii::app()->createUrl('u/hovercard'))));?>

	Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::link('EduWind','http://eduwind.com'); ?>水木信步<br/>
	</div><!-- footer -->

</div><!-- page -->
<?php

$this->widget('application.extensions.fancybox.EFancyBox', array(
 //   'target'=>'.dxd-fancy-elem',
    'config'=>array(
		'type'=>'iframe',
		'hideOnOverlayClick'=>false,
  //      'maxWidth'    => 500,
  //      'maxHeight'   => 200,
        'fitToView'   => false,
        'autoSize'    => true,
        'closeClick'  => false,
        'openEffect'  => 'none',
        'closeEffect' => 'none',
//		'onClosed'=>'js:function(){window.location.reload();}'
    ),
));
?>
		<?php  $this->widget('application.extensions.kindeditor.KindEditor',
                    array(
                        )
                    ); ?>

                    <style type="text/css">
#footer{
position: absolute;
margin: 0;
bottom: 0;
display: block;
width: 100%;
font-size: 1em;
z-index: 5;
overflow: hidden;
padding:10px 0;
text-align:center;
background-color:#f0f0f0;
}
</style>
</body>
</html>
