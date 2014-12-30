<?php

/**
 * MailerForm class.
 * MailerForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class MailerForm extends CFormModel
{
	public $host;
	public $username;
	public $password;
	public $port;
	public $enabled;
	/**
	 * Declares the validation rules.
	 * The rules status that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('host,username,password,port,enabled', 'required'),
		);
	}
	
	public function behaviors(){
		return array(
				'setting'=>array('class'=>'SettingBehavior',
								 'item'=>'mailer'),		
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'host'=>Yii::t('app','发信服务器（推荐163邮箱，如smtp.163.com)'),
			'username'=>Yii::t('app','邮箱用户（如xxx@163.com）'),
			'password'=>Yii::t('app','邮箱密码'),
			'port'=>Yii::t('app','邮箱端口(一般为25）'),
			'enabled'=>Yii::t('app','邮件发送'),
		);
	}

}
