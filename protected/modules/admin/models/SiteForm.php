<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SiteForm extends CFormModel
{
	public $icp;
	public $name="EduWind";
	public $subTitle= "又一个EduWind站点";
	public $superAdminEmail;
	public $analytic;
	public $version = "1.6.4";
	public $startVersion = "1.6.4";
	public $copyright = "北京水木信步网络科技有限公司";
	public $urlFormat = "query";
	public $install = false;
	public $logo;
	public $poweredBy="EduWind";
	public $poweredByUrl = "http://eduwind.com";
	/**
	 * Declares the validation rules.
	 * The rules status that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('name,icp,subTitle,adminEmail,urlFormat,version', 'length', 'max'=>64),
			array('logo,poweredBy,poweredByUrl','length','max'=>512),
			array('analytic','length','max'=>64000),
		);
	}
	
	public function behaviors(){
		return array(
				'setting'=>array('class'=>'SettingBehavior',
								 'item'=>'site'),		
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'icp'=>Yii::t('app','ICP备案号'),
			'name'=>Yii::t('app','网站名称'),
			'subTitle'=>Yii::t('app','网站副标题'),
			'urlFormat'=>Yii::t('app','URL格式'),
			'superAdminEmail'=>Yii::t('app','超级管理员邮箱'),
			'analytic'=>Yii::t('app','站点统计代码'),
			'logo'=>'Logo',
			'poweredBy'=>'Powered By',
			'poweredByUrl'=>Yii::t('app','Powered By 链接'),
		);
	}

}
