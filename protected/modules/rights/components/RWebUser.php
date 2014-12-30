<?php
/**
* Rights web user class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.5
*/
class RWebUser extends CWebUser
{

	public function init()
	{
		//parent::init();
        $this->attachBehaviors($this->behaviors);
        //$this->_initialized=true;

		Yii::app()->getSession()->open();
		
		if($this->getIsGuest() && $this->allowAutoLogin){
            //从cookie得到用户的id
            $userId = $this->getUserIdFromCookie();
            //查看是否有session登记到userId名下,没有的话，恢复用户的身份，否则什么都不做
            if(!Yii::app()->getSession()->getUserOldSession($userId))
			    $this->restoreFromCookie();
			if(!$this->getIsGuest()){   //如果用cookie-based login 恢复了登录的状态
                //记录登录情况
                $category=EwDbLogRoute::LOGIN_AUTO;
                $level=CLogger::LEVEL_INFO;
                $msg = serialize(array('message'=>EwDbLogRoute::LOGIN_AUTO_MSG,'userId'=>$this->getId()));;
                Yii::log($msg,$level,$category);

                //向session表中记录用户的id
                Yii::app()->getSession()->writeUserId($this->getId());
            }
		}
		elseif($this->autoRenewCookie && $this->allowAutoLogin)
		$this->renewCookie();
		if($this->autoUpdateFlash)
			$this->updateFlash();
	
		$this->updateAuthStatus();
	}

    private function getUserIdFromCookie(){
        $app=Yii::app();
        $request=$app->getRequest();
        $cookie=$request->getCookies()->itemAt($this->getStateKeyPrefix());
        $id = 0;
        if($cookie && !empty($cookie->value) && is_string($cookie->value) && ($data=$app->getSecurityManager()->validateData($cookie->value))!==false)
        {
            $data=@unserialize($data);
            if(is_array($data) && isset($data[0],$data[1],$data[2],$data[3]))
            {
                list($id,$name,$duration,$states)=$data;
            }
        }
        return $id;
    }

	
	/**
	* Actions to be taken after logging in.
	* Overloads the parent method in order to mark superusers.
	* @param boolean $fromCookie whether the login is based on cookie.
	*/
	public function afterLogin($fromCookie)
	{
		parent::afterLogin($fromCookie);
		// Mark the user as a superuser if necessary.
		if( Rights::getAuthorizer()->isSuperuser($this->getId())===true )
			$this->isSuperuser = true;
	}

	/**
	* Performs access check for this user.
	* Overloads the parent method in order to allow superusers access implicitly.
	* @param string $operation the name of the operation that need access check.
	* @param array $params name-value pairs that would be passed to business rules associated
	* with the tasks and roles assigned to the user.
	* @param boolean $allowCaching whether to allow caching the result of access checki.
	* This parameter has been available since version 1.0.5. When this parameter
	* is true (default), if the access check of an operation was performed before,
	* its result will be directly returned when calling this method to check the same operation.
	* If this parameter is false, this method will always call {@link CAuthManager::checkAccess}
	* to obtain the up-to-date access result. Note that this caching is effective
	* only within the same request.
	* @return boolean whether the operations can be performed by this user.
	*/
	public function checkAccess($operation, $params=array(), $allowCaching=true)
	{
		// Allow superusers access implicitly and do CWebUser::checkAccess for others.
		return $this->isSuperuser===true ? true : parent::checkAccess($operation, $params, $allowCaching);
	}

	/**
	* @param boolean $value whether the user is a superuser.
	*/
	public function setIsSuperuser($value)
	{
		$this->setState('Rights_isSuperuser', $value);
	}

	/**
	* @return boolean whether the user is a superuser.
	*/
	public function getIsSuperuser()
	{
		return $this->getState('Rights_isSuperuser');
	}
	
	/**
	 * @param array $value return url.
	 */
	public function setRightsReturnUrl($value)
	{
		$this->setState('Rights_returnUrl', $value);
	}
	
	/**
	 * Returns the URL that the user should be redirected to 
	 * after updating an authorization item.
	 * @param string $defaultUrl the default return URL in case it was not set previously. If this is null,
	 * the application entry URL will be considered as the default return URL.
	 * @return string the URL that the user should be redirected to 
	 * after updating an authorization item.
	 */
	public function getRightsReturnUrl($defaultUrl=null)
	{
		if( ($returnUrl = $this->getState('Rights_returnUrl'))!==null )
			$this->returnUrl = null;
		
		return $returnUrl!==null ? CHtml::normalizeUrl($returnUrl) : CHtml::normalizeUrl($defaultUrl);
	}
}
