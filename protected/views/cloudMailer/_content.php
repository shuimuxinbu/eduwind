<?php 
global $sysSettings;
?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<div  style="background:#E1E3F8;color:#333;width:100%;height:100%;padding-bottom:10px;">
		<div style="width:500px;margin:20px auto;">
			<h3 style="font-size:24px;padding:20px 20px 3px 0px; margin-bottom:0px;" ><?php echo $sysSettings['site']['name'];?></h3>
			<div style="background:#fff;padding:20px;line-height:2em;">
				<div style="padding-bottom:20px;border-bottom:1px solid #ddd;">
					<div style="padding-bottom:15px;"><?php echo $user->name;?>你好：</div>
					<?php
					$count = 0;
					 foreach($items as $item):
						echo strip_tags($this->renderPartial('_item',array('item'=>$item,'user'=>$user)),true);
						echo "<br/>";
						if($count++>=2) break;
					 endforeach;?>
				</div>
				<div style="padding:20px 0 40px 20px;border-bottom:1px solid #ddd;">登录后，点击链接查看全部消息<br/>
					<?php echo CHtml::link(Yii::app()->createAbsoluteUrl('//notice'),Yii::app()->createAbsoluteUrl('//notice'));?>
				</div>
				<div style="padding-top:20px;">
					<span style="color:gray;"><?php echo $sysSettings['site']['name'];?></span>
					|&nbsp;&nbsp;
					<?php echo CHtml::link('取消邮件通知',Yii::app()->createAbsoluteUrl('//me/receiveMailNotify'));?>
				</div>
				<div style="clear:both;"></div>
				<div style="display:none">您之所以收到此邮件是因为您曾经在%webname%注册了账号， 本邮件由%web%根据您关注的内容生成，希望能提供您感兴趣的内容。 我们保证您的邮箱地址将只用于%webname%邮件的接受，您也可以随时取消邮件的订阅。 如果您不愿再收到邮件，请点击取消订阅。 如果觉得邮件内容有用，可以将发件人邮箱加入白名单，以确保后期即使接收邮件。 如果此封邮件在垃圾箱中，请将此邮件取回，防止邮件被定期删除。</div>
			</div>
		</div>
	</div>

