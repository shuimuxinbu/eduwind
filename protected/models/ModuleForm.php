<?php

/**
 * MailerForm class.
 * MailerForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ModuleForm extends CFormModel
{
	public $activeModules=array();
	public $navModules=array();

	/**
	 * Declares the validation rules.
	 * The rules status that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
		            array('activeModules,navModules','type','type'=>'array','allowEmpty'=>true),
		   );
	}
	
	public function behaviors(){
		return array(
				'setting'=>array('class'=>'SettingBehavior',
								 'item'=>'module'),		
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(

		);
	}

}
