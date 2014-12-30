<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SRegisterForm extends CFormModel
{
	public $isEnabled;
	public $message;
	

		
	/**
	 * Declares the validation rules.
	 * The rules status that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('isEnabled','numerical', 'integerOnly'=>true),
			array('message','length','max'=>1024),
		);
	}
	
	public function behaviors(){
		return array(
				'setting'=>array('class'=>'SettingBehavior',
								 'item'=>'register'),		
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'isEnabled'=>'是否开启',
			'message'=>'关闭提示',
		);
	}

}
