<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class OpenAuthForm extends CFormModel
{
	public $enabled=false;
	public $rennEnabled = false;
	public $rennAppId;
	public $rennApiKey;
	public $rennSecretKey;
	/**
	 * Declares the validation rules.
	 * The rules status that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('enabled,rennEnabled,rennAppId','numerical', 'integerOnly'=>true),
			array('rennApiKey,rennSecretKey', 'length', 'max'=>64),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'enabled'=>Yii::t('app','是否开启开放登录'),
			'rennEnabled'=>Yii::t('app','是否开启人人账号登录'),
			'rennAppId'=>'App ID',
			'rerenApiKey'=>'Api Key',
			'rennSecretKey'=>'Secret Key',
		);
	}

	public function behaviors(){
		return array(
				'setting'=>array('class'=>'SettingBehavior',
								 'item'=>'openAuth'),		
		);
	}
}
