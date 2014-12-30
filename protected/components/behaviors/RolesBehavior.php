<?php
class RolesBehavior extends CActiveRecordBehavior {
	private $_arrRoles;


	/**
	 * 是否在某一个用户组中
	 * @param array $targetRoles
	 */
	public function inRoles($targetRoles){
		foreach($this->arrRoles as $item){
			if(in_array($item, $targetRoles)) return true;
		}
		return false;
	}


	/**
	 * 设置用户角色
	 * @param array/string $targetRoles
	 */
	public function setArrRoles($targetRoles){
		if(!$targetRoles){ $this->_arrRoles = array();}
		else if(is_array($targetRoles)){
			$this->_arrRoles = $targetRoles;
		}
		$this->owner->roles = implode(',',$this->_arrRoles);
		
	}

	/**
	 * 获取用户角色数组
	 * @param array/string $targetRoles
	 */
	public function getArrRoles(){
		if($this->owner->roles){		
			$this->_arrRoles = explode(',',$this->owner->roles);
			return $this->_arrRoles;
		}else{
			return array();
		}
	}
	
	/**
	 * 获取本member中角色权限不比$userId低的角色,如果操作者不是同一组织的成员，则返回本成员所有roles
	 * Enter description here ...
	 * @param unknown_type $userId
	 */
/*	public function getNoLowerRoles(){
		if(get_class($this->owner)=="UserInfo"){
			$operator = UserInfo::model()->findByPk(Yii::app()->uer->id);
			$object = $this->owner->isNewRecord ? $this->owner : UserInfo::model()->findByPk($this->owner->id);	
		}else{
		
		if( Yii::app()->user->checkAccess('admin')) return array();
		$userId = Yii::app()->user->id;
		$operator = Member::model()->findByAttributes(array('userId'=>$userId,'memberableEntityId'=>$this->memberableEntityId));
		
		$object = $this->isNewRecord ? $this : {get_class($this->owner)}::model()->findByAttribute($this->id);
			
		}

		
		
		if( Yii::app()->user->checkAccess('admin')) return array();
		$userId = Yii::app()->user->id;
//		$operateMember = Member::model()->findByAttributes(array('userId'=>$userId,'memberableEntityId'=>$this->memberableEntityId));
		
		$objectMember = $this->isNewRecord ? $this : Member::model()->findByPk($this->id);
		if($operateMember){
			$result = array();
			if($objectMember->inRoles(array('superAdmin'))) $result[] = 'superAdmin';
			//if($operateMember->inRoles(array('superAdmin'))) return array('superAdmin');
			if($operateMember->inRoles(array('admin'))){
				if($objectMember->inRoles(array('admin'))) $result[]='admin';
			}
			return $result;
		}
		return $objectMember->arrRoles;

	}*/
	/**
	 * 不允许操作权限级别比操作者搞的role
	 */
/*	protected function beforeSave(){
		//var_dump($this->_arrRoles);
		
		$noLowerRoles = $this->getNoLowerRoles();
		$this->arrRoles = array_merge($this->arrRoles,$noLowerRoles);
		$this->arrRoles = array_unique($this->arrRoles);
		return parent::beforeSave();
	}*/
}