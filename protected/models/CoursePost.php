<?php

/**
 * This is the model class for table "ew_course_post".
 *
 * The followings are the available columns in table 'ew_course_post':
 * @property integer $id
 * @property integer $courseId
 * @property integer $lessonId
 * @property string $title
 * @property string $content
 * @property integer $upTime
 * @property integer $addTime
 * @property integer $userId
 * @property integer $commentNum
 * @property integer $viewNum
 * @property integer $voteNum
 * @property integer $isTop
 * @property integer $isDigest
 * @property integer $voteUpNum
 * @property integer $voteDownNum
 * @property integer $commentableEntityId
 * @property integer $entityId
 */
class CoursePost extends EntityActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{course_post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('courseId,  content, userId', 'required'),
			array('courseId, lessonId, upTime, addTime, userId, commentNum, viewNum, voteNum, isTop, isDigest, voteUpNum, voteDownNum, commentableEntityId, entityId', 'numerical', 'integerOnly'=>true),
			array('content,title','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			array('title', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, courseId, lessonId, title, content, upTime, addTime, userId, commentNum, viewNum, voteNum, isTop, isDigest, voteUpNum, voteDownNum, commentableEntityId, entityId', 'safe', 'on'=>'search'),
		);
	}
	public function behaviors(){
		return array(
			'commentable'=>array('class'=>'CommentableBehavior'),
			'voteable'=>array('class'=>'VoteableBehavior'),
			//'voteable'=>array('class'=>'application.components.behaviors.FollowableBehavior'),
			'followable'=>array('class'=>'FollowableBehavior'),
		    'softDeleteActiveRecordBehavior' => array(
                                'class' => 'SoftDeleteBehavior',
             ),	
             'CTimestampBehavior' => array(
			'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'addTime',
          	  	 'updateAttribute'=>'upTime',
		)	
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
			'course'=>array(self::BELONGS_TO,'Course','courseId'),
			'lesson'=>array(self::BELONGS_TO,'Lesson','lessonId'),
			'user' => array(self::BELONGS_TO, 'UserInfo', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'courseId' => 'Course',
			'lessonId' => 'Lesson',
			'title' => Yii::t('app','标题'),
			'content' => Yii::t('app','内容'),
			'upTime' => 'Up Time',
			'addTime' => 'Add Time',
			'userId' => 'User',
			'commentNum' => 'Comment Num',
			'viewNum' => 'View Num',
			'voteNum' => 'Vote Num',
			'isTop' => 'Is Top',
			'isDigest' => 'Is Digest',
			'voteUpNum' => 'Vote Up Num',
			'voteDownNum' => 'Vote Down Num',
			'commentableEntityId' => 'Commentable Entity',
			'entityId' => 'Entity',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('courseId',$this->courseId);
		$criteria->compare('lessonId',$this->lessonId);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('upTime',$this->upTime);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('commentNum',$this->commentNum);
		$criteria->compare('viewNum',$this->viewNum);
		$criteria->compare('voteNum',$this->voteNum);
		$criteria->compare('isTop',$this->isTop);
		$criteria->compare('isDigest',$this->isDigest);
		$criteria->compare('voteUpNum',$this->voteUpNum);
		$criteria->compare('voteDownNum',$this->voteDownNum);
		$criteria->compare('commentableEntityId',$this->commentableEntityId);
		$criteria->compare('entityId',$this->entityId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave(){
		if(!$this->upTime)
			$this->upTime = time();
		return parent::beforeSave();
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CoursePost the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
