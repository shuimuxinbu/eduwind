<?php
require_once 'AbleBehavior.php';
class CategoryableBehavior extends AbleBehavior{
	public $itemType = "category";

	public function getType(){
		$class = get_class($this->getOwner());
		return lcfirst($class);
	}

	/**
	 * 设置分类
	 * @param unknown_type $categoryName
	 */
	public function setCategoryByName($name){
		$category = $this->addCategory($name);
		return $this->setCategory($category->getPrimaryKey());
	}

	public function addCategory($name){
		$type = $this->getType();
		$category = Category::model()->findByAttributes(array('name'=>$name));
		if(!$category){
			$category = new Category();
			$category->name = $name;
			$category->type = $type;
			$category->addTime = time();
			$category->save();
		}
		return $category;
	}
	/**
	 * 设置分类
	 * @param unknown_type $categoryId
	 */
	public function setCategory($categoryId){
		$owner = $this->getOwner();
		$owner->categoryId = $categoryId;
		return $owner->save();
	}

	public function getCategorys($exCriteria){
		$criteria = new CDbCriteria();
		$criteria->condition = "type='".lcfirst(get_class($this->owner))."'";
		$criteria->order = "weight asc";
		$criteria->mergeWith($exCriteria);
		return Category::model()->findAll($criteria);
	}

	public function getDataProviderByCategory($categoryId=0,$pageSize=4){
		$owner = $this->getOwner();
		$ownerClass = get_class($owner);
		$criteria = new CDbCriteria();
		$criteria->with = "category";
		if(isset($owner->weight))
			$criteria->order = 'weight asc';
		$criteria->condition = "(categoryId=$categoryId or category.parentId=$categoryId) and category.type='".lcfirst($ownerClass)."'";
		return  new CActiveDataProvider($ownerClass,array('criteria'=>$criteria,'pagination'=>array('pageSize'=>$pageSize)));
	}

	//组装分类Menu组件所需的items
	public  function getCategoryItems(){
		//查找缓存
		/*		if(($cache=Yii::app()->cache)!==null){
		$key="Wii.Category.items";
		if(($items=$cache->get($key))!==false){
		return $items;
		}
		}*/
		$type= $this->getType();
		//查找数据库，并组装
		$items=array(
		//			array('label'=>'好友创建','url'=>array('course/userFollowedCreated'),'visible'=>!Yii::app()->user->isGuest),
		//			array('label'=>'关注用户推荐','url'=>array('course/userFollowedRecommended'),'visible'=>!Yii::app()->user->isGuest),
		//			array('label'=>'关注话题','url'=>array('course/topicFollowed'),'visible'=>!Yii::app()->user->isGuest),
		//	array('label'=>'最新 & 热门','url'=>array($type.'/index')),
		//	array('label'=>'类别')
		);
		$cates = Category::model()->findAll(array('condition'=>"parentId=0 and type='$type'",'order'=>'weight asc'));
		foreach($cates as $cate){

			$items[] = array('label'=>$cate->name,"url"=>array($type.'/category','id'=>$cate->id));
			//			$subCates = Category::model()->findAll(array('condition'=>"parentId=$cate->id",'order'=>'weight asc'));
			//			foreach($subCates as $subCate){
			//				$items[] = array('label'=>" ".$subCate->name,'url'=>array($type.'/category','id'=>$subCate->id));
			//			}
			}
			//如果item组装成功，则缓存之
			if($items!==null){
				if(isset($key)){
					$cache->set($key,$items,3000);
				}
				return $items;

			}else{
				return null;
			}

	}
	public function getAllCategories(){
		$categorys = Category::model()->findAllByAttributes(array('type'=>$this->getType()));
		return $categorys;
	}


}

