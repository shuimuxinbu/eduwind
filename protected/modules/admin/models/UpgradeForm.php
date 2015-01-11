<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UpgradeForm extends CFormModel
{
	public $serverUrl="http://www.eduwind.com/index.php?r=";
	public $version = "1.2.0";
	
		
	/**
	 * Declares the validation rules.
	 * The rules status that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('serverUrl', 'length', 'max'=>255),
			//array('','numerical', 'integerOnly'=>true),
		);
	}
	
	public function behaviors(){
		return array(
				'setting'=>array('class'=>'SettingBehavior',
								 'item'=>'upgrade'),		
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'upgradeUrl'=>Yii::t('app','升级服务器地址'),
		);
	}

}
