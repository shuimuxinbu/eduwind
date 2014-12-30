<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class PaymentForm extends CFormModel
{
	public $aliGuaranPartner;
	public $aliGuaranKey;	
	public $means;
//	public $aliGuaranEnabled;
	public $aliGuaranSellerAccount;
	
	public $aliPartner;
	public $aliKey;
	public $aliSellerAccount;
		
	
	public $stripePublishableKey;
	public $stripeSecretKey;
	/**
	 * Declares the validation rules.
	 * The rules status that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('aliGuaranKey,aliKey', 'length', 'max'=>32),
			array('aliGuaranPartner,aliPartner','length','max'=>16),
			array('aliGuaranSellerAccount,aliSellerAccount,stripePublishableKey,stripeSecretKey','length','max'=>64),
			array('means','length','max'=>255),
			//array('','numerical', 'integerOnly'=>true),
		);
	}
	
	public function behaviors(){
		return array(
				'setting'=>array('class'=>'SettingBehavior',
								 'item'=>'payment'),		
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'aliGuaranSellerAccount'=>Yii::t('app','收款账号'),
			'aliGuaranPartner'=>Yii::t('app','合作伙伴id'),
			'aliGuaranKey'=>Yii::t('app','安全检验码'),
			'aliSellerAccount'=>Yii::t('app','收款账号'),
			'aliPartner'=>Yii::t('app','合作伙伴id'),
			'aliKey'=>Yii::t('app','安全检验码'),
			'means'=>Yii::t('app','支付工具'),
			'aliEnabled'=>Yii::t('app','是否使用支付宝'),
		);
	}

}
