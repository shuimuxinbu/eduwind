<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class PartnerForm extends CFormModel
{
	public $mode;
	public $config;
	

		
	/**
	 * Declares the validation rules.
	 * The rules status that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('config','type','type'=>'string'),
			array('mode','length','max'=>64),
		);
	}
	
	public function behaviors(){
		return array(
				'setting'=>array('class'=>'SettingBehavior',
								 'item'=>'partner'),		
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'mode'=>Yii::t('app','集成对象'),
			'isEnabled'=>Yii::t('app','是否开启'),
			'config'=>Yii::t('app','配置信息'),
		);
	}

}
