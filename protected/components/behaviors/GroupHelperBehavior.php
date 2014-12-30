<?php
//require_once 'MemberableBehavior.php';

class GroupHelperBehavior extends CBehavior{

	
	/**
	 * 新加入一个用户
	 *  @param unknown_type $userId
	 */
/*	public function join($userId){
		$group = $this->getOwner();
		//插入一条新数据
		$groupMember = new GroupMember;
		$groupMember->userId = $userId;
		$groupMember->groupId = $group->id;
		$groupMember->addTime = time();
		//加入方式free或apply
		if($group->joinType=="free"){
			$groupMember->role = "member";
				if($groupMember->save()){
					Yii::app()->user->setFlash('success',"加入小组成功！");
					return $groupMember->role;
				}	
		}else{
			$groupMember->role = "unquestioned_applicant" ;
			if($groupMember->save()){
				Yii::app()->user->setFlash('success',"回答问题后才能申请加入小组！");
				return $groupMember->role;
			}	
		}
		$this->onMemberNumChanged();
			
	}
	*/
	/**
	 * 加入用户
	 * Enter description here ...
	 * @param unknown_type $id
	 */
/*	public function quit(){
		$groupMember = GroupMember::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'groupid'=>$this->getOwner()->id));
		if($groupMember){
			//此处checkAccess
			return $groupMember->delete();
		}
	}
*/
	/**
	 * 计算用户在本小组内回答问题的次数
	 * Enter description here ...
	 * @param unknown_type $userId
	 */
	public function getUserAnswerCount($userId){
		$group = $this->getOwner();
		$answerCount = 0;
		foreach($group->testQuestions as $question){
			$answer = Answer::model()->findByAttributes(array('userId'=>$userId,'questionid'=>$question->id));
			if($answer) $answerCount++;
		}
		return $answerCount;
	}
	
	//处理创事件
/*	public function handleOnCreated($event){
			//添加默认用户
			$groupMember = new GroupMember();
			$owner = $this->getOwner();
			$groupMember->userId = $owner->userId;
			$groupMember->role = 'superAdmin';
			$groupMember->groupId= $owner->getPrimaryKey();
			$groupMember->save();
		
	}*/
	
	//处理数量变化时间
/*	public function handleOnMemberNumChanged($event){
		$owner = $this->getOwner();
		$owner->memberNum = $owner->memberCount;
		$owner->save();
	}
*/	
	/**
	 * 返回dataprovider
	 * @param unknown_type $c
	 */
/*	public function getMemberDataProvider($c=array()){
				$c = array_merge_recursive(
								  array('criteria'=>array('condition'=>'groupId=:groupId and role in ("superAdmin","superAdmin","member")',
								  						  'params'=>array( ':groupId'=>$this->getOwner()->getPrimaryKey()),
								  						  'with'=>'user')),
								  $c);
		return new CActiveDataProvider("GroupMember",$c);
	}
	/**
	 * (non-PHPdoc)
	 * @see MemberableBehavior::findMember()
	 */
/*	public function findMember($c){
		return GroupMember::model()->with('user')->findByAttributes($c);
	}*/
}
