<?php

class CloudMailerController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
		array('allow','actions'=>array('daily'),'users'=>array('*')),
		array('deny'  // deny all users
		),
		);
	}

	public function actionDaily($domain="sandbox1df13445d6654ec287f37549d6efca0b.mailgun.org",$key="key-114d3601cdf1046397e7d228e17030db"){
		$this->_sendNoticeAndMessage($domain,$key);
	}
	
	private function _sendNoticeAndMessage($domain,$key){
			if (!isset($domain) || !isset($key)) exit(Yii::t('app','URL请求不正确'));
		if((substr(PHP_VERSION,0,3) < 5.3)) exit(Yii::t('app',"php 版本过低"));

		//	$sql = "left join ew_user_info u on t.toUserId=u.id group by toUserId order by addTime desc ";
		$criteria = new CDbCriteria();
		$sql = "select distinct userId from ew_notice union select distinct toUserId as userId from ew_message";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		Yii::import('ext.mailgun.EMailgun');
		$count = 0;
		global $sysSettings;
		foreach($rows as $row){
			$user = UserInfo::model()->findByPk($row['userId']);
			$messages = Message::model()->findAllByAttributes(array('toUserId'=>$row["userId"],'isChecked'=>0,'isMailed'=>0)); 
			$notices = Notice::model()->findAllByAttributes(array('userId'=>$row["userId"],'isChecked'=>0,'isMailed'=>0)); 
			$items = array_merge($messages,$notices);
			//$data = array_merge($messageDataProvider->getData(),$noticeDataProvider->getData())；
			$subject = $this->renderPartial('_subject',
			array('items'=>$items),
			true);
			$content = $this->renderPartial('_content',
			array('items'=>$items,'user'=>$user),
			true);
			
			$params =   array('api_user' => 'postmaster@samebook.sendcloud.org',
            'api_key' => 'kO9VzZMINWi1PQnu',
            'from' => "no-reply@eduwind.com",
            'fromname' => $sysSettings['site']['name'],
            'to' => $user->email,
            'subject' => $subject?$subject:Yii::t('app',"你有新的消息"),
            'html' => $content);
			$result = DxdUtil::sendCloudMail($params);

	//		$mgClient = new EMailgun($key);

/*			$result = $mgClient->sendMessage(
			$domain,
			array(
	                'from'    =>"Mailgun Sandbox <postmaster@sandbox1df13445d6654ec287f37549d6efca0b.mailgun.org>",
	                'to'      => $user->email,
	                'subject' => $subject,
	                'html'    => $content
			)
			);*/
			var_dump($result);
			if($result->message=="success"){
				foreach($notices as $notice){
					$notice->isMailed = 1;
					$notice->save();
				}
				foreach($messages as $message){
					$message->isMailed = 1;
					$message->save();
				}
				$count++;
				echo $user->email."<br/>";
				
			}
		}
		echo "send mail to $count users <br/>\n";
	}
	
	

}
