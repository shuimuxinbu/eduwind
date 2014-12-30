<div style="width:100%;min-height:500px;background-color:#F1F8FD;">
	<div style="margin:0 auto;width:500px;padding-top:30px;">
		<div style="font-size:28px;">&nbsp;<?php echo Yii::app()->params['settings']['site']['name'];?><sup style="font-size:14px"><em> <?php echo Yii::app()->params['settings']['site']['subTitle'];?></em></sup></div>
		<div style="min-height:200px;background-color:#fff;padding:20px;">
			<?php echo Yii::t('app','您好：')?><br/>
			<?php echo Yii::t('app','您申请了邮箱找回密码。')?><br/>
			<?php echo Yii::t('app','点击以下链接，即可重新设置您的"{name}"登录密码',array('{name}'=>Yii::app()->params['settings']['site']['name']);?>
			<br/><br/>
			<div>
				<?php echo CHtml::link($link,$link);?>
			</div>
			<br/>
			<!--  
			<em style="color:#777">
			支持Chrome，FireFox和IE9+浏览器
			</em>
			-->
			<hr style="margin:10px 0;border: 0;border-top: 1px solid #eeeeee;border-bottom: 1px solid #ffffff;">
			<div style="color:#777">
				<?php echo CHtml::link(Yii::app()->params['settings']['site']['name'],$this->createAbsoluteUrl('site/index'));?> @ 
			<?php echo date('Y',time());?>
			</div>
		</div>
	</div>
</div>
