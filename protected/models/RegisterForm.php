<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegisterForm extends CActiveRecord
//class RegisterForm extends CFormModel
{
	public $name;
	public $password;
	public $email;
	public $bio;
	public $password2;


	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * Declares the validation rules.
	 * The rules status that name and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		$rules = array(
		// name and password are required
		array('name, email, password, password2, bio', 'required'),
		array('email','unique','className'=>'User'),
		array('name','unique','className'=>'UserInfo'),
		array('password','length','min'=>6,'max'=>32),
		array('password2', 'compare', 'compareAttribute'=>'password', 'message'=>'两次 密码 不一致'),
		array('name','length','min'=>2,'max'=>32,'tooShort'=>'用户名太短'	,'tooLong'=>'用户名太长'),
		array('bio','length','min'=>1,'max'=>200),
		array('email','email'),
		);
		global $sysSettings;
		if(isset($sysSettings['partner']['mode']) && $sysSettings['partner']['mode']=='ucenter'){
			$rules[] = array('email','checkUcenterEmail');
			$rules[] = array('name','checkUcenterName');
				
		}
		return $rules;
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'name'=>Yii::t('app','姓名'),
			'password'=>Yii::t('app','密码'),
			'password2'=>Yii::t('app','重复密码'),
			'email'=>Yii::t('app','邮箱地址'),
			'bio'=>Yii::t('app','一句话介绍你自己'),
		);
	}


	/**
	 * Logs in the user using the given name and password in the model.
	 * @return boolean whether login is successful
	 */
	public function register()
	{
		return User::model()->addUser($this->email,$this->password,
										array('status'=>'created','bio'=>$this->bio,'name'=>$this->name));
	}

	public function checkUcenterEmail($attribute,$params)
	{
		//ucenter
		Yii::import('ext.ucenter.MUcenter',true);
		$flag = uc_user_checkemail($this->email);

		switch($flag)
		{
			case -4:
				$this->addError('email', 'Email 格式有误');
				break;
			case -5:
				$this->addError('email','Email 不允许注册');
				break;
			case -6:
				$this->addError('email','该 Email 已经被注册');
				break;
		}
	}

	public function checkUcenterName($attribute,$params)
	{
		//ucenter
		Yii::import('ext.ucenter.MUcenter',true);
		$flag = uc_user_checkname($this->name);

		switch($flag)
		{
			case -1:
				$this->addError('name', Yii::t('app','用户名不合法'));
				break;
			case -2:
				$this->addError('name',Yii::t('app','包含不允许注册的词语'));
				break;
			case -3:
				$this->addError('name',Yii::t('app','用户名已经存在'));
				break;
		}
	}
}

