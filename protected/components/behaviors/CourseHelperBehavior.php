<?php
//require_once 'MemberableBehavior.php';

class CourseHelperBehavior extends CBehavior{

	/**
	 * 添加一个视频
	 */
	public function addLessonByUri($mediaUri){
		if($mediaUri){
			$lesson = new Lesson;
			$lesson->mediaSource = "link";
			$lesson->mediaUri=$mediaUri;
			return $this->addLesson($lesson);
		}
	}
	/**
	 * 添加一个lesson
	 * @param unknown_type $lesson
	 */
	public function addLesson($lesson){
		$owner = $this->getOwner();

		$lesson->userId = Yii::app()->user->id;
		$lesson->courseId = $owner->id;

		$lesson->addTime = time();
		//处理外链类型的视频
		if($lesson->mediaSource && $lesson->mediaSource!="self" && $lesson->mediaSource!="cloud" && $lesson->mediaType!="text"){
			if(strpos($lesson->mediaUri,'http://')!==0){
				$lesson->mediaUri = 'http://'.$lesson->mediaUri;
			}
			if(strpos($lesson->mediaUri, '.swf')===false){
				Yii::import('ext.videolink.VideoLink');
				$video = new VideoLink;
				$result = $video->parse($lesson->mediaUri);
				if($result) {
					$lesson->mediaUri = $result['swf'];
					$lesson->mediaSource = $result['source'];
					$lesson->mediaName = $result['title'];
					$lesson->mediaType = "video";
				}
			}
		}
		if(!$lesson->title) $lesson->title=$lesson->mediaName;
		$lesson->status = Lesson::STATUS_HIDDEN;
		return $lesson->save();
	}
	/**
	 * 添加一个多个
	 */
	public function addLessonsByUri($lessonListUri){
		Yii::import('ext.videolink.VideoList');
		$videolist = new VideoList();
		$videos = $videolist->parse($lessonListUri);
		$count = 0;
		foreach($videos as $item){
			$lesson = new Lesson;
			$lesson->courseId = $this->getOwner()->id;
			if($this->addLesson($lesson)){
				$count++;
			}
		}
		return $count==count($videos) ?  true : false;

	}
	/**
	 * 提取课时
	 */
	public function getLessonDataProvider($c=array(),$onlyPublished=true){
		$owner = $this->getOwner();
		if($onlyPublished){
			$c = array_merge_recursive($c,array('criteria'=>array('condition'=>'status=:status and courseId='.$owner->id,'order'=>'weight asc','params'=>array(':status'=>Course::STATUS_OK))));
		}else{
			$c = array_merge_recursive($c,array('criteria'=>array('condition'=>'courseId='.$owner->id,'order'=>'weight asc')));
		}
		return new CActiveDataProvider('Lesson',$c);
	}

	/**
	 * 调整顺序
	 * @param unknown_type $idsString
	 */
	public function orderLessons($idsString){
		$ids = explode(",",$idsString);
		for($i=0;$i<count($ids);$i++){
			$lesson = Lesson::model()->findbyPk($ids[$i]);
			if ($lesson && $lesson->courseId==$this->getOwner()->id)
			{
				$lesson->updateByPk( $ids[$i],array("weight"=>$i+1) );
			}
		}
		return true;
	}
	
	public function addMember($userId){
		$member = new CourseMember;
		$member->startTime = time();
		$member->courseId = $this->owner->id;
		$member->userId = $userId;
		$member->roles = "student";
	//	$course = Course::model()->findByAttributes(array('userId'=>$userId,'id'=>$member->courseId)
		if($this->owner->limitTime)
		$member->endTime = $member->startTime + $this->owner->limitTime;
		else 
			$member->endTime = 0;
		return $member->save();
	}
	
	public function findMember($c=array()){
		$c = array_merge_recursive($c,array('courseId'=>$this->owner->id));
		return CourseMember::model()->findByAttributes($c);
		//'userId'=>Yii::app()->user->id
	}
	
		/**
	 * 返回dataprovider
	 * @param unknown_type $c
	 */
/*	public function getMemberDataProvider($c=array()){
		$c = array_merge_recursive(
		array('criteria'=>array('condition'=>'memberableEntityId=:memberableEntityId and (find_in_set("superAdmin",t.roles) or find_in_set("admin",t.roles) or find_in_set("member",t.roles))',
								  						  'params'=>array( ':memberableEntityId'=>$this->getOwner()->entityId),
								  						  'with'=>'user')),
		$c);
		return new CActiveDataProvider("CourseMember",$c);
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
	*/
	
	private function getLessonEntityIds(){
		$criteria = new CDbCriteria();
		$criteria->select = "entityId";
		$criteria->condition = "courseId=".intval($this->owner->id);
		$lessons = Lesson::model()->findAll($criteria);
		$lessonEntityIds = array();
		foreach($lessons as $lesson){
			$lessonEntityIds[] = $lesson->entityId;
		}
		return $lessonEntityIds;
	}
	
	public function getCommentDataProvider($pageSize=4){
		$criteria = new CDbCriteria();
		$lessonEntityIds = $this->getLessonEntityIds();
		$entityIds = array_merge($lessonEntityIds,array($this->owner->entityId));
		$criteria->addInCondition('commentableEntityId', $entityIds);
	//	$criteria->condition = "referId=0";
		$criteria->order = "addTime desc";
		$dataProvider = new CActiveDataProvider('Comment',array('criteria'=>$criteria,'pagination'=>array('pageSize'=>$pageSize)));
		return $dataProvider;
	}
}
