<?php

/**
 * This is the model class for table "ew_quiz_report".
 *
 * The followings are the available columns in table 'ew_quiz_report':
 * @property integer $id
 * @property integer $quizId
 * @property integer $userId
 * @property string $score
 * @property integer $correctNum
 * @property integer $wrongNum
 * @property integer $partialcorrectNum
 * @property string $teacherRemark
 */
class QuizReport extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{quiz_report}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('quizId, userId', 'required'),
		array('quizId, userId, correctNum, wrongNum, partialCorrectNum,remarkTime,addTime', 'numerical', 'integerOnly'=>true),
		array('score', 'length', 'max'=>7),
		array('teacherRemark', 'safe'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, quizId, userId, score, correctNum, wrongNum, partialCorrectNum, teacherRemark', 'safe', 'on'=>'search'),
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
			'quiz'=>array(self::BELONGS_TO,"Quiz",'quizId'),
			'user'=>array(self::BELONGS_TO,'UserInfo','userId'),
		);
	}
	
	public function getResponses(){
		$responses =array();
		foreach($this->quiz->questions as $question){
			$responses[] = $question->userResponse($this->userId);
		}		
		return $responses;
	}

	/*	public function behaviors(){
		return array(
		'CTimestampBehavior' => array(
		'class' => 'zii.behaviors.CTimestampBehavior',
		'createAttribute' => 'addTime',
		'updateAttribute'=>false,
		)
		);
		}
		*/

	public function refreshStat(){
		$this->correctNum=0;
		$this->partialCorrectNum=0;
		$this->wrongNum=0;
		$this->score=0;
		foreach($this->quiz->questions as $question){
			$response = $question->userResponse($this->userId);
			if($response){
				if($response->status==QuestionResponse::STATUS_CORRECT) $this->correctNum++;
				elseif($response->status==QuestionResponse::STATUS_PARTIAL_CORRECT) $this->partialCorrectNum++;
				elseif($response->status==QuestionResponse::STATUS_WRONG) $this->wrongNum++;
				$this->score+=$response->score;
			}
		}
		$this->save();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quizId' => 'Quiz',
			'userId' => 'User',
			'score' => 'Score',
			'correctNum' => 'Right Num',
			'wrongNum' => 'Wrong Num',
			'partialcorrectNum' => 'Partial Right Num',
			'teacherRemark' => 'Teacher Remark',
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
		$criteria->compare('quizId',$this->quizId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('score',$this->score,true);
		$criteria->compare('correctNum',$this->correctNum);
		$criteria->compare('wrongNum',$this->wrongNum);
		$criteria->compare('partialCorrectNum',$this->partialcorrectNum);
		$criteria->compare('teacherRemark',$this->teacherRemark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QuizReport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
