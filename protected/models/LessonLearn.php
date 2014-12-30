<?php

/**
 * This is the model class for table "ew_lesson_learn".
 *
 * The followings are the available columns in table 'ew_lesson_learn':
 * @property integer $id
 * @property integer $lessonId
 * @property integer $userId
 * @property integer $startTime
 * @property integer $finishTime
 * @property integer $status
 */
class LessonLearn extends CActiveRecord
{
	const STATUS_START=1;
	const STATUS_FINISH = 2;
	const STATUS_NOT_START = 0;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lesson_learn}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('lessonId, userId', 'required'),
		array('lessonId, userId, startTime, finishTime, status', 'numerical', 'integerOnly'=>true),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, lessonId, userId, startTime, finishTime, status', 'safe', 'on'=>'search'),
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
			'lesson'=>array(self::BELONGS_TO,"Lesson",'lessonId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lessonId' => 'Lesson',
			'userId' => 'User',
			'startTime' => 'Start Time',
			'finishTime' => 'Finish Time',
			'status' => 'Status',
		);
	}

	public function init($lessonId=0,$userId=0){
		if($lessonId!=0)
		$this->lessonId = $lessonId;
		if($userId!=0)
		$this->userId = $userId;
		return parent::init();
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
		$criteria->compare('lessonId',$this->lessonId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('startTime',$this->startTime);
		$criteria->compare('finishTime',$this->finishTime);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function start(){
		$this->startTime = time();
		$this->status = self::STATUS_START;
		return $this->save();
	}

	public function finish(){
		$this->finishTime = time();
		$this->status = self::STATUS_FINISH;
		return $this->save();
	}

	public function notFinish(){
		$this->finishTime = 0;
		$this->status = self::STATUS_START;
		return $this->save();
	}


	public function lessonCount($userId,$courseId,$status=self::STATUS_FINISH){
		$criteria = new CDbCriteria();
		$criteria->join = "left join ew_lesson l on t.lessonId=l.id";
		$criteria->condition = "t.userId=:userId and t.status=:status and l.courseId=:courseId";
		$criteria->params = array(':courseId'=>$courseId,':userId'=>$userId,':status'=>$status);
		return self::model()->count($criteria);
	}

	public function nextLesson($courseId,$userId){
		$criteria = new CDbCriteria();
		$criteria->join = "inner join {{lesson}} l";
		$criteria->condition = 'l.courseId=:courseId and finishTime=0 and t.userId=:userId';
		$criteria->params = array(':courseId'=>$courseId,':userId'=>$userId);
		$criteria->order = "weight asc";
		$learn = self::model()->find($criteria);
		if($learn && $learn->lesson) return $learn->lesson;

		$criteria = new CDbCriteria();
		$criteria->select = "lessonId";
		$criteria->join = "inner join {{lesson}} l";
		$criteria->condition = 'l.courseId=:courseId and t.userId=:userId';
		$criteria->params = array(':courseId'=>$courseId,'userId'=>$userId);
		$learns = self::model()->findAll($criteria);
		$lessonIds = array();
		foreach($learns as $learn){
			$lessonIds[] = $learn->lessonId;
		}

		$criteria = new CDbCriteria();
		$criteria->addCondition('courseId=:courseId');
		$criteria->params = array(':courseId'=>$courseId);
		$criteria->addNotInCondition('id', $lessonIds);
		$criteria->order = "weight asc";
		$lesson = Lesson::model()->find($criteria);
		return $lesson;
	}

	public function  checkFinish($lessonId,$userId){
		return $this->countByAttributes(array('lessonId'=>$lessonId,'userId'=>$userId,'status'=>self::STATUS_FINISH));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LessonLearn the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
