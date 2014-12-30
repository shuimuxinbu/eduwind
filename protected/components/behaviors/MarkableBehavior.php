<?php
//require_once 'AbleBehavior.php';
class MarkableBehavior extends AbleBehavior{
	public $itemType = "mark";
	public $tags = array();
	/**
	 * 返回TagActDataProvider
	 */
	public function getMarkDataProvider($c=array()){
		$c =array('criteria'=>array('with'=>'tag'));
		return $this->getItemDataProvider($c);
	}
	
	/**
	 * 根据TagActDataProvider得到Tags Array
	 */
	public function getTags() {
		if ($this->tags === array()) {
			$marks = $this->getMarkDataProvider()->getData();
			foreach ($marks as $mark) {
				$this->tags[] = $mark->tag;
			}
		}
		return $this->tags;
	}
	
	/**
	 * 得到以逗号分隔的tag列表字符串
	 */
	public function getTagNamesString() {
		if($this->tags === array())
			$this->tags = $this->getTags();
		//为tag名字准备数组
		$tagNames = array();
		foreach ($this->tags as $tag)	//当前markable对象的每个tag
			$tagNames[] = $tag->name;	//将tag名字填入数组
		return implode(', ', $tagNames);	//返回以逗号分隔的tag名字字符串
	}
	
	/**
	 * 将新的tag对象列表与原有列表进行比较，将新的tag加入mark表，将旧的tag从mark表中移除
	 * @param unknown_type $newTagNames:传入的tag名字数组
	 */
	public function updateMarks($newTagNames) {
		//新tag的对象数组
		$newTags = Tag::getTagsByNames($newTagNames);
		
		if($this->tags === array())
			$this->tags = $this->getTags();
		
		//原tag的id数组
		$oldTagIds = $this->getIdsFromTags($this->tags);
		//新tag的id数组
		$newTagIds = $this->getIdsFromTags($newTags);
		
		//得到应当移除的tag的id
		$unBindTagIds = array_diff($oldTagIds, $newTagIds);
		//得到应当添加的tag的id
		$newBindTagIds = array_diff($newTagIds, $oldTagIds);
		//取得当前的markable对象
		$owner = $this->getOwner();
		
		//进行移除工作
		foreach($unBindTagIds as $unBindTagId) {
			$mark = Mark::model()->findByAttributes(array('markableEntityId'=>$owner->entityId, 'tagId'=>$unBindTagId));
			$mark->delete();
		}
		//进行添加工作
		foreach($newBindTagIds as $newBindTagId) {
			$mark = new Mark;
			$mark->markableEntityId = $owner->entityId;
			$mark->tagId = $newBindTagId;
			$mark->save();
		}
		
		//更新tag
		$this->tags = $newTags;
	}
	
	/**
	 * 从tag对象数组中抽取出tag id数组
	 * @param unknown_type $tags:tag对象数组
	 */
	private function getIdsFromTags($tags) {
		$ids = array();
		foreach ($tags as $tag) {
			$ids[]=$tag->id;
		}
		return $ids;
	}
}