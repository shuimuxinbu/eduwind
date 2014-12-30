<?php
//require_once 'MemberableBehavior.php';

class SettingBehavior extends CBehavior{

	var $_key="Wii.SystemSetting.settings";
	public $shadowFileName = "/data/settings.php";
	public $item;

	//获取所有系统设置，返回关联数组
	protected function getAllSystemSettings(){
		//查找缓存
/*		if(($cache=Yii::app()->cache)!==null){
			if(($settings=$cache->get($this->_key))!==false){
				return $settings;
			}
		}*/
		//查找数据库
		$settings=array();
		foreach(SystemSetting::model()->findAll() as $index=>$objSetting){
			$settings[$objSetting->name] = json_decode($objSetting->value,true);
		}
		return $settings;
		//如果item组装成功，则缓存之
/*		if($settings!==null){
			if(isset($this->_key)){
				$cache->set($this->_key,$settings,3000);
			}
			return $settings;

		}else{
			return null;
		}*/
	}


	//将多个设置存入数据库，并更新缓存
	protected   function save($settings){
		$result = true;
		foreach($settings as $key=> $value){
			$item = SystemSetting::model()->findByAttributes(array('name'=>$key));
			if(!$item) {
				$item = new SystemSetting();
				$item->name = $key;
			}
			$item->value = json_encode($value);
			if(!$item->save()){
				$result = false;
			}
		}

		if(($cache =Yii::app()->cache)!==null)
			$cache->delete($this->_key);

		return $result;
	}

	/**
	 * 将属性转换为关联数组输出
	 * Enter description here ...
	 */
	public function saveSetting(){
		if(!$this->item) return false;
		if($this->save(array($this->item=>$this->getOwner()->getAttributes()))){
			//此处写入文件
			$allSettings = $this->getAllSystemSettings();
			if(!file_put_contents(Yii::app()->basePath.$this->shadowFileName,'<?php  return '.var_export($allSettings,true).";")){
				$result = false;
			}
			return true;
		}
		return false;
	}

	/**
	 * 从数据库中提取数据，并填充本对象
	 * Enter description here ...
	 */
	public function getSetting(){
		$settings = $this->getAllSystemSettings();
		if(isset($settings[$this->item])){
			$this->getOwner()->attributes =  $settings[$this->item];
		}
	}

}
