<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<div class="well col-sm-7 center" style="margin-top:100px;font-size:1.5em;line-height:1.5em;">
<div class="pull-left">
<?php echo CHtml::image(Yii::app()->baseUrl.'/images/han.jpg',"",array('style'=>'width:100px;height:100px;'));?>
</div>
<div style="margin:0px 0 0 120px">
<?php echo Yii::t('app','抱歉！您的浏览器不被支持，建议您使用以下浏览器:')?> <br/>
<?php echo CHtml::link('Chrome','https://www.google.com/intl/zh-CN/chrome/browser/')?>，
<?php echo CHtml::link('FireFox','http://www.firefox.com.cn/')?>，
<?php echo CHtml::link('Safari','http://support.apple.com/kb/DL1531')?>，
<?php echo Yii::t('app','IE9，IE10或搜狗浏览器高速模式');?>
</div>
<div class="clearfix"></div>
</div>
<script type="text/javascript">
if(isBrowserSupport()){
	window.location.href="<?php echo Yii::app()->baseUrl;?>";
}
</script>
