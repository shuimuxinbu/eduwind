<?php
class NavPage extends CComponent{
	/**
	 * 将page组装成nav item
	 * Enter description here ...
	 */
	public static function getPageItems(){
		$pageDataProvider = new CActiveDataProvider('BottomText',array('criteria'=>array('order'=>'weight asc ')));
		$items = array();
		foreach($pageDataProvider->getData() as $page){
			$item['content'] = $page->content;
			$items[] = $item;
		}
		return $items;
	}
}
