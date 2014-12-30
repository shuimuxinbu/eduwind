<?php
/**
 * 用来render markable对象的tag 显示
 * @author hyhylee
 *
 */
class TagWidget extends CWidget {
	//当前markable对象拥有的tag名字字符串（以逗号连接）
	public $tagNamesString;
	
	public $allTagNamesString;
	public $callBackUrl;
	public $historyUrl;
	public $allowEdit = true;
	
	public function run(){
		$this->render('_tag',
				array(
					'tagNamesString'=>$this->tagNamesString,
					'allTagNamesString'=>$this->allTagNamesString,
					'callBackUrl'=>$this->callBackUrl,
					'historyUrl'=>$this->historyUrl,
					'allowEdit'=>$this->allowEdit,
				)		
		);
	}
}