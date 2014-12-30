<?php
class MemberableBehavior extends AbleBehavior{
	public $superAdminName = "superAdmin";
	public $adminName = "admin";
	public $ordinaryMemberName = "member";
	public $memberNames = array("superAdmin",'admin','member');
//	private $authLevel=array('superAdmin'=>1,'admin'=>2);
	public $roleLabel = array('superAdmin'=>'超级管理员','admin'=>'管理员','student'=>'学生','teacher'=>'教师','member'=>'成员');
	private $_maxLevel=1000;
	//绑定事件
	public function events(){
		return array(
			'onCreated'=>'handleOnCreated',
		);
	}
	/**
	 * 返回角色对应的字符串
	 * @param unknown_type $role
	 */
	public function getRoleLabel($role){
		if(isset($this->roleLabel[$role])) return $this->roleLabel[$role];
		return "";
	}

	
	/**
	 * 新加入一个用户
	 *  @param unknown_type $userId
	 */
	public function addMember($userId,$roles=array()){
		$owner = $this->getOwner();
		$member = Member::model()->findByAttributes(array('memberableEntityId'=>$owner->entityId,
														  'userId'=>$userId));
		if(!$roles) $roles = $this->getDefaultRoles();
		if(!$member){
			//插入一条新数据
			$member = new Member;
			$member->userId = $userId;
			$member->memberableEntityId = $owner->entityId;
			$member->addTime = time();
			$member->setArrRoles($roles);
			$result = $member->save();
			$this->onAdded(new CEvent);
			return $result;
		}
		return false;
	}

	public function authLevel($role){
		if(isset($this->authLevel[$role])) return $this->authLevel;
		else return count($authLevel)+1;		
	}

	/**
	 * 剔除用户
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function removeMember($userId){
		$owner = $this->getOwner();
		$member = Member::model()->findByAttributes(array('userId'=>$userId,
														  'memberableEntityId'=>$owner->entityId));

		if($member && !$member->inRoles(array("superAdmin"))){
			//此处checkAccess
			if($member->userId==Yii::app()->user->id || Yii::app()->user->checkAccess('memberAdmin',array('memberableEntityId'=>$owner->entityId))){
				if( $member->delete()){
//					Yii::app()->user->setFlash('success',"退出成功");
					$this->onRemoved(new CEvent());
					return true;
				}
			}
		}
//		Yii::app()->user->setFlash('error',"退出失败");
		return false;
	}



	//处理创事件
	public function handleOnCreated($event){
		//添加默认用户
		$this->addMember(Yii::app()->user->id,array('superAdmin'));

	}

	public function assignRole($userId,$role){
		/*		$owner = $this->getOwner();
		 $member = Member::model()->findByAttributes(array('userId'=>$userId,
		 'memberableEntityId'=>$owner->entityId));
		 if($role==$this->superAdmin){
			return false;
			}else if($role==$this->admin && $owner->userId!=)*/
	}

	//处理数量变化时间
	public function handleOnAdded($event){
		$this->refreshNum();
	}

	public function handleOnRemoved($event){
		$this->refreshNum();
	}


	public function refreshNum(){
		$owner = $this->getOwner();
		if(isset($owner->memberNum)){
			$owner->memberNum = $this->getMemberCount();
			$owner->save();
		}
	}

	public function getDefaultRoles(){
		$owner = $this->getOwner();
		if(isset($owner->joinType)){
			switch ($owner->joinType=="free"){
				case 'free':
					return array($this->ordinaryMemberName);
				case 'apply':
					return array('applicant');
				case 'pay':
			}
		}
		return array($this->ordinaryMemberName);
	}

	/**
	 * 返回dataprovider
	 * @param unknown_type $c
	 */
	public function getMemberDataProvider($c=array()){
		$c = array_merge_recursive(
		array('criteria'=>array('condition'=>'memberableEntityId=:memberableEntityId and (find_in_set("superAdmin",t.roles) or find_in_set("admin",t.roles) or find_in_set("member",t.roles))',
								  						  'params'=>array( ':memberableEntityId'=>$this->getOwner()->entityId),
								  						  'with'=>'user')),
		$c);
		return new CActiveDataProvider("Member",$c);
	}
	
	public function getMemberDataProviderByRole($role){
		$c = array('criteria'=>array('condition'=>'memberableEntityId=:memberableEntityId and find_in_set(:role,t.roles)',
								  						  'params'=>array( ':memberableEntityId'=>$this->getOwner()->entityId,
																			':role'=>$role),
								  						  'with'=>'user'));
		$result = new CActiveDataProvider("Member",$c);		
	//	var_dump($result->getData());
		return $result;
	}
	/**
	 * (non-PHPdoc)
	 * @see MemberableBehavior::findMember()
	 */
	public function findMember($c){
		$owner = $this->getOwner();
		$c = array_merge($c,array('memberableEntityId'=>$owner->entityId));
		return Member::model()->with('user')->findByAttributes($c);
	}
	/**
	 * 获取成员数量，计入超级管理员
	 */
	public function getMemberCount(){
		$result = Member::model()->count("memberableEntityId=:entityId and (find_in_set('superAdmin',roles) or find_in_set('admin',roles) or find_in_set('member',roles))",array(':entityId'=>$this->getOwner()->entityId));
		return intval($result);

	}
	/**
	 * 查找某人在组织中的角色
	 * @param unknown_type $userId
	 */
/*	public function lookUpRole($userId=0){
		if(!$userId) $userId = Yii::app()->user->id;
		$member = $this->findMember(array('userId'=>$userId));
		if($member) return $member->role;
		return "";
	}*/
}
