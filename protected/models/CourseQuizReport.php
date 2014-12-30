<?php

/**
 * This is the model class for table "ew_course_quiz_report".
 *
 * The followings are the available columns in table 'ew_course_quiz_report':
 * @property integer $id
 * @property integer $userId
 * @property integer $courseId
 * @property string $quizIds
 * @property string $avgScore
 * @property string $totalScore
 * @property integer $quizNum
 * @property integer $correctNum
 * @property integer $partialCorrectNum
 * @property integer $wrongNum
 */
class CourseQuizReport extends CActiveRecord
{
	public $arrQuizIds;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{course_quiz_report}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('userId, courseId', 'required'),
		array('userId, courseId, quizNum, correctNum, partialCorrectNum, wrongNum', 'numerical', 'integerOnly'=>true),
		array('quizIds', 'length', 'max'=>255),
		array('avgScore, totalScore', 'length', 'max'=>5),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, userId, courseId, quizIds, avgScore, totalScore, quizNum, correctNum, partialCorrectNum, wrongNum', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' => 'User',
			'courseId' => 'Course',
			'quizIds' => 'Quiz Ids',
			'avgScore' => 'Avg Score',
			'totalScore' => 'Total Score',
			'quizNum' => 'Quiz Num',
			'correctNum' => 'Correct Num',
			'partialCorrectNum' => 'Partial Correct Num',
			'wrongNum' => 'Wrong Num',
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('courseId',$this->courseId);
		$criteria->compare('quizIds',$this->quizIds,true);
		$criteria->compare('avgScore',$this->avgScore,true);
		$criteria->compare('totalScore',$this->totalScore,true);
		$criteria->compare('quizNum',$this->quizNum);
		$criteria->compare('correctNum',$this->correctNum);
		$criteria->compare('partialCorrectNum',$this->partialCorrectNum);
		$criteria->compare('wrongNum',$this->wrongNum);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function refreshStat(){
		$criteria = new CDbCriteria();
		$criteria->select = "mediaId";
		$criteria->condition = "mediaType='quiz' and courseId=".intval($this->courseId);
		$lessons = Lesson::model()->findAll($criteria);
		$this->arrQuizIds = array();
		foreach($lessons as $lesson){
			$this->arrQuizIds[] = $lesson->mediaId;
		}
		$this->totalScore = $this->totalScoreCount;
		$this->quizNum = $this->quizCount;
		$this->avgScore = $this->quizNum==0 ? 0: $this->totalScore/$this->quizNum;
		$this->save();
	}


	public function getUser(){
			return UserInfo::model()->findByPk($this->userId);
	}

	public function getCourse(){
			return Course::model()->findByPk($this->courseId);
	}



	public function getTotalScoreCount(){
		$totalScore = 0;
		$criteria = new CDbCriteria();
		$criteria->addInCondition('quizId',$this->arrQuizIds);
		$criteria->compare('userId', $this->userId);
		$criteria->select = "score";
		//	$criteria->select = "count(*) as quizCount";
		$quizReports = QuizReport::model()->findAll($criteria);
		foreach($quizReports as $report){
			$totalScore +=$report->score;
		}
		return $totalScore;
	}
	public function getQuizCount(){
		$count = 0;
		$criteria = new CDbCriteria();
		$criteria->addInCondition('quizId',$this->arrQuizIds);
		$criteria->compare('userId', $this->userId);
		//	$criteria->select = "count(*) as quizCount";
		return QuizReport::model()->count($criteria);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CourseQuizReport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
