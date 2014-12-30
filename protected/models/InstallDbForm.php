<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class InstallDbForm extends CFormModel
{
	public $dbName;
	public $dbUser;
	public $dbPassword;
	public $host;
	public $create=1;
	
	/**
	 * Declares the validation rules.
	 * The rules status that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
		// username and password are required
		array('dbName,dbUser,host', 'required'),
		array('dbPassword','length','max'=>255),
		array('create','numerical', 'integerOnly'=>true)	
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'host'=>Yii::t('app','主机地址'),
			'dbUser'=>Yii::t('app','用户名'),
			'dbName'=>Yii::t('app','数据库名'),
			'dbPassword'=>Yii::t('app','密码'),
			'create'=>Yii::t('app','如果指定数据库不存在，则创建数据库')
		);
	}
}
