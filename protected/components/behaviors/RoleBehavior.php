<?php
class RoleBehavior extends CBehavior{

//	public $arrRoles;

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
		if(!$targetRoles){ $this->arrRoles = array();}
		else if(is_array($targetRoles)){
			$this->arrRoles = $targetRoles;
		}
		$this->owner->roles = implode(',',$this->arrRoles);
		
	}

	/**
	 * 获取用户角色数组
	 * @param array/string $targetRoles
	 */
	public function getArrRoles(){
		if($this->owner->roles){		
			$this->arrRoles = explode(',',$this->owner->roles);
			return $this->arrRoles;
		}else{
			return array();
		}
	}
}
