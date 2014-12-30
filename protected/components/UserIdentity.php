<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_userInfo;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate($oauth=false)
	{	
		global $sysSettings;
		if(isset($sysSettings['partner']['mode']) && $sysSettings['partner']['mode']=='ucenter'){
			Yii::import('ext.ucenter.MUcenter',true);
			list($ucenterId, $username, $password, $email) = uc_user_login($this->username, $this->password,2);  
			$this->_authenticate($oauth);
			if($ucenterId > 0 && $this->errorCode== self::ERROR_USERNAME_INVALID)  {  
                //说明网站数据库中没有，而ucenter中有这个用户，添加用户   
				User::model()->addUser($email,$password,array('name'=>$username,'bio'=>' ','status'=>'ok'));   
				$this->errorCode=self::ERROR_NONE;
			}else if($ucenterId>0 && $this->errorCode==self::ERROR_PASSWORD_INVALID){
				$this->errorCode = self::ERROR_NONE;
			}else if($ucenterId == -1 && $this->errorCode == self::ERROR_NONE){	
				uc_user_register($this->userInfo->name, $this->password, $this->userInfo->email);
			}
			$this->setState('ucenterId',$ucenterId);
		}else{
			$this->_authenticate($oauth);
		}
		if($this->errorCode == self::ERROR_NONE){
			$userInfo =$this->userInfo;
			$userInfo->upTime = time();
			$userInfo->save();
			//动态设为超级用户
			if($userInfo->isAdmin) Yii::app()->user->setIsSuperuser(true);

			$this->_id = $userInfo->id;
			//用setState添加的变量会加入Yii::app()->user的属性中
			$this->setState('displayName',$userInfo->name);
		}

		return !$this->errorCode;
	}
	//Yii::app()->user->id会调用此函数
	public function getId()
	{
		return $this->_id;
	}


	public function getUserInfo(){
		if(!$this->_userInfo){
			$this->_userInfo = UserInfo::model()->findByAttributes(array('email'=>$this->username));
		}
		return $this->_userInfo;
	}

	protected function _authenticate($oauth){
		$user = User::model()->findByAttributes(array('email'=>$this->username));
		if(!$user)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($oauth)
			$this->errorCode = self::ERROR_NONE;
		elseif(!$user->comparePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;

	}
}