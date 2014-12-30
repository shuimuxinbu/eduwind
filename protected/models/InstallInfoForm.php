<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class InstallInfoForm extends CFormModel
{
	public $name;
	public $subTitle;
	public $adminEmail;
	public $adminPassword;
	public $adminName;
	public $adminBio = "管理员";
	
	/**
	 * Declares the validation rules.
	 * The rules status that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('name,adminEmail,adminName,adminPassword', 'required'),
			array('adminEmail, adminName,subTitle', 'length', 'max'=>64),
			array('adminEmail','email'),
			array('adminName,email','unique','className'=>'UserInfo','attributeName' => 'email'),			
			array('adminPassword','length','max'=>32,'min'=>5)
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'adminName'=>Yii::t('app','管理员名号'),
			'adminEmail'=>Yii::t('app','管理员邮箱'),
			'adminPassword'=>Yii::t('app','管理员密码'),
			'name'=>Yii::t('app','网站名称'),
			'subTitle'=>Yii::t('app','网站副标题'),
		);
	}
}
