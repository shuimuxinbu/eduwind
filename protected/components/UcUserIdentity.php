<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UcUserIdentity extends CUserIdentity
{   
	private $_id;
	
	/**
	 * Constructor.
	 * @param string $username username
	 */
	public function __construct($username)
	{
		$this->username=$username;
		$this->password='';
	}
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$userInfo = UserInfo::model()->findByAttributes(array('name'=>$this->username));
		Yii::import('ext.ucenter.MUCenter',true);
		list($uid, $username, $email) = uc_get_user($this->username);		
		if($userInfo == null){
			//说明网站数据库中没有，而ucenter中有这个用户，添加用户
			if($uid){
				$user = User::model()->addUser($email,DxdUtil::randCode(8),array('name'=>$username,'bio'=>' ','status'=>'ok'));
			}
		}

		$userInfo = UserInfo::model()->findByAttributes(array('name'=>$this->username));
	//	error_log(print_r($userInfo,true));
		if($userInfo){
			$this->username = $userInfo->email;
			$userInfo->upTime = time();
			$userInfo->save();
			//动态设为超级用户
			$this->_id = $userInfo->id;
			//用setState添加的变量会加入Yii::app()->user的属性中
			$this->setState('displayName',$userInfo->name);	
			$this->setState('ucenterId',$uid);
			$this->errorCode=self::ERROR_NONE;	

		}else{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}

		return !$this->errorCode;
	}

	public function getId()
	{
		error_log("id".$this->_id);
		return $this->_id;
	}
}