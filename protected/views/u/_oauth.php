<?php
		if((isset(Yii::app()->params['settings']['openAuth']['enabled']) && Yii::app()->params['settings']['openAuth']['enabled'])
			&& (isset(Yii::app()->params['settings']['openAuth']['rennEnabled']) && Yii::app()->params['settings']['openAuth']['rennEnabled'])){
			$rennService = new RennService();
			$rennClient = $rennService->getClient();
			$code_url = $rennClient->getAuthorizeURL(Yii::app()->createAbsoluteUrl('/oauth/rennAuth'), 'code');
			$img = CHtml::image(Yii::app()->baseUrl."/images/renren_connect.png");
			echo CHtml::link($img,$code_url);
		}
