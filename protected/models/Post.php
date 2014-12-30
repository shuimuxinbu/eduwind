<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property integer $postid
 * @property string $title
 * @property string $content
 * @property integer $addTime
 * @property integer $upTime
 * @property integer $userId
 * @property integer $courseId
 *
 * The followings are the available model relations:
 * @property Tcomment[] $tcomments
 * @property User $user
 * @property Course $course
 */
class Post extends EntityActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors(){
		return array(
			'commentable'=>array('class'=>'CommentableBehavior'),
			'voteable'=>array('class'=>'VoteableBehavior'),
			//'voteable'=>array('class'=>'application.components.behaviors.FollowableBehavior'),
			'followable'=>array('class'=>'FollowableBehavior'),
			'postHelper'=>array('class'=>'PostHelperBehavior'),
		    'softDeleteActiveRecordBehavior' => array(
                                'class' => 'SoftDeleteBehavior',
             ),		
		);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId,title,content,groupId','required'),
			array('upTime, addTime, userId, commentNum, voteUpNum, voteDownNum,isTop, isDigest, postableEntityId', 'numerical', 'integerOnly'=>true),
			array('content','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),			
			array('title', 'length', 'max'=>255),
			array('id, title, content, upTime, addTime, userId, commentNum, voteUpNum,voteDownNum, isTop, isDigest, postableEntityId', 'safe', 'on'=>'search'),	
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'postableEntity'=> array(self::BELONGS_TO, 'Entity', 'postableEntityId'),
//			'comments' => array(self::HAS_MANY, 'Comment', 'postid',
//					'order'=>'addTime DESC'),
			'user' => array(self::BELONGS_TO, 'UserInfo', 'userId'),
			'author' => array(self::BELONGS_TO, 'UserInfo', 'userId'),
			'course' => array(self::BELONGS_TO, 'Course', 'courseId'),	
			'group' => array(self::BELONGS_TO, 'Group', 'groupId'),	
		            // 通过Post.entityId 取得 最新的一条Comment数据
//			'commentCount' => array(self::STAT, 'Comment', 'postid'),
//			'votedownCount'=>array(self::STAT,'Vote','postid','condition'=>"value<=0"),
//			'voteupCount'=>array(self::STAT,'Vote','postid','condition'=>"value>0"),
//			'voteUpers'=>array(self::MANY_MANY,'UserInfo','vote(entityId,userId)','condition'=>"value>0"),
			
		);
	}

	public  function getLastComment(){
		$criteria = new CDbCriteria();
		$criteria->condition = "t.commentableEntityId=".$this->entityId;
		$criteria->order = "addTime desc";
		$result = Comment::model()->find($criteria);
		return $result;
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'postid' => 'Postid',
			'title' => Yii::t('app','标题'),
			'content' => Yii::t('app','内容'),
			'addTime' => Yii::t('app','创建时间'),
			'upTime' => Yii::t('app','更新时间'),
			'userId' => 'Userid',
			'courseId' => 'Courseid',
		);
	}


	/**
	 * comment事件
	 * Enter description here ...
	 * @param unknown_type $event
	 */		
/*	public function onCommentAdded($event){
		$this->raiseEvent("onCommentAdded",$event);
	}
*/	

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('postid',$this->postid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('upTime',$this->upTime);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('courseId',$this->courseId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
/*
	public function updateVoteCount(){
		$sql = "select count(voteid) as num from post p left join post_comment c on p.postid=c.postid left join post_comment_vote v on v.commentid=c.commentid where p.postid=".$this->postid;
		$count = Yii::app()->db->createCommand($sql)->queryRow();
		$this->count_vote = $count['num'] + $this->voteupCount + $this->votedownCount;
		$this->save();

	}*/
	
	public function getPageUrl(){
		return Yii::app()->createUrl('/group/post/view',array('id'=>$this->id));
	}
}
