<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ThirdPartyLoginForm  extends CFormModel
{
	public $qqAppId;
	public $qqKey;	
	public $qqEnable = false;
	public $means;
//	public $aliGuaranEnabled;
	
	/**
	 * Declares the validation rules.
	 * The rules status that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('qqKey,qqAppId', 'length', 'max'=>32),
			array('qqEnable,renrenEnable','boolean','trueValue'=>1,'falseValue'=>-1,'message'=>'the value must be 1 or -1'),
			array('means','length','max'=>255),
			//array('','numerical', 'integerOnly'=>true),
		);
	}
	
	public function behaviors(){
		return array(
				'setting'=>array('class'=>'SettingBehavior',
								 'item'=>'thirdpartylogin'),		
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'qqAppId'=>'qqAppId',
			'qqKey'=>'qqKey',
			'qqEnable'=>'是否接入qq',
			'means'=>'接入方法',
			'renrenEnable' => '是否接入renren',
		);
	}

}
