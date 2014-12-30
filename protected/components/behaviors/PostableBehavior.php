<?php
class PostableBehavior extends AbleBehavior{
	public $itemType = "post";


	/**
	 * 返回postDataProvider
	 */
	public function getPostDataProvider($c=array()){
		return $this->getItemDataProvider($c);
	}
	/**
	 * 添加post
	 */
	public function addPost($post){
		//$this->addItem($post);
		$post->addTime = time();
		$post->upTime = time();
		$post->userId = Yii::app()->user->id;
		$post->postableEntityId = $this->getOwner()->entityId;
		return $post->save();
	}

	/**
	 * 删除post
	 * @param unknown_type $post
	 */
	public function deletePost($post){
		return $post->delete();
	}
}
