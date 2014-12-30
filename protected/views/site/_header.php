<?php
/* @var $this SiteController */
?>
<!-- 
<div class="row" style="background-color:#206bac;color:white;padding:20px;">
	<div class="col-sm-6">
		<div class="lead" style="line-height: 3em">
		EduWind开源教学软件<br/>
		<ul >
			<li>快速搭建自己的属于自己的网络教学平台</li>
			<li>响应式设计，支持手机浏览器浏览</li>
			<li>完全开源</li>
		</ul>
		
		</div>	
	</div>
	<div class="col-sm-6">
	
	</div>
</div>
-->
    <div class="hero-unit">
    <h1><span style="color:red"><?php echo Yii::t('app','学术印象')?></span><?php echo Yii::t('app','互动展示平台');?></h1>
    <p style="margin-top:15px;"><?php echo Yii::t('app','采用国际前沿的在线教育架构（Udemy，Edx）和顶级高校（Stanford,MIT）的宣传布局风格，帮助帮助教育、科研机构迅速搭建个性化的在线互动展示平台。适用于高校院系、实验室、科研机构、培训机构等。')?>
    <p>
	    <?php echo CHtml::link(Yii::t('app','联系我们'),array('page/view','id'=>4),array('class'=>"btn btn-primary btn-large " ));?>
	    <?php 
	    echo CHtml::link(Yii::t('app','了解更多'),array('site/page','view'=>'more'),array('class'=>'btn btn-large ml10'))
	    ?>

    </p>
    </div>
