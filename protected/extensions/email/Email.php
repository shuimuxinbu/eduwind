<?php
/**
*	邮件类
**/


class Email{
	
	public $content;
	public $fromAddr="notification@samebook.net";
	public $toAddr;
	public $subject;
	public $replyToAddr="notification@samebook.net";
	public $fromName;
	
	private $accountBatch = array('user'=>"postmaster@daxidao-batch.sendcloud.org",'pwd'=>'kPBGxqiJ');
	private $accountTran = array('user'=>"postmaster@daxidao-tran.sendcloud.org",'pwd'=>'5CmD5pur');
	
	/*
	 * 发送邮件，分批量发送和触发发送两种类型
	 */
	public function send($type="batch"){
		if(!$this->fromName) $this->fromName = Yii::app()->params['settings']['site']['name'];
		$account = $type=='batch' ? $this->accountBatch : $this->accountTran;
		if(!$this->content) return false;
		
		require_once dirname(__FILE__).'/../sendcloud/SendCloudLoader.php';
		try{
			$sendCloud = new SendCloud($account['user'], $account['pwd']);
			$message = new SendCloud\Message();
			$message->addRecipient($this->toAddr) // 添加第一个收件人
			->setSubject($this->subject)
			->setReplyTo($this->replyToAddr) // 添加回复地址
			->setFromName($this->fromName) // 添加发送者称呼
			->setFromAddress($this->fromAddr) // 添加发送者地址  // 邮件主题
			->setBody($this->content); // 邮件正文html形式
			$message->setAltBody('要查看邮件，请使用HTML兼容的电子邮件阅读器');// 邮件正文纯文本形式，这个不是必须的。
			return $sendCloud->send($message);
		} catch (Exception $e) {
			//error_log("邮件发送出错:".$e->getMessage());
			//echo "邮件发送出错:".$e->getMessage();
			return  false;
		}
		
		return true;
	}
}