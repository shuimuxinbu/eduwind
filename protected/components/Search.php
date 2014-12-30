<?php
/**
 * 搜索相关事宜
 * Enter description here ...
 * @author ryoukinhua
 *
 */
class Search extends CComponent{
	public static function highlightWord($str,$word){
		return str_ireplace($word, '<span class="dxd-search-keyword">'.$word."</span>", $str);
	}
	
	/**
	 * like 方法搜索
	 * @param unknown_type $modelName
	 * @param unknown_type $attributes
	 * @param unknown_type $keyword
	 * @param unknown_type $pageSize
	 * @param unknown_type $order
	 */
	public static function like($modelName,$attributes,$keyword,$pageSize,$order=null){
		
		$conditions = array();
		foreach($attributes as $index=>$attribute){
			$conditions[] = " $attribute like :match ";
		}
		$condition = implode(" or ", $conditions);
		$dataProvider=new CActiveDataProvider($modelName,array(
			'criteria'=>array(
							  'condition'=>$condition,
							  'order'=>$order,
		 					  'params'=>array(':match'=>"%$keyword%")
		),
			'pagination'=>array(
        		'pageSize'=>$pageSize,
		)));

		return $dataProvider;
			
	}
}