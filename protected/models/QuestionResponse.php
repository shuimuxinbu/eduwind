<?php

/**
 * This is the model class for table "ew_answer".
 *
 * The followings are the available columns in table 'ew_answer':
 * @property integer $id
 * @property integer $userId
 * @property integer $questionId
 * @property string $content
 */
class QuestionResponse extends CActiveRecord
{
	public $choices= array();
	const STATUS_CORRECT=2;
	const STATUS_PARTIAL_CORRECT = 1;
	const STATUS_WRONG = 0;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{question_response}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('userId, questionId', 'required'),
		array('userId, questionId', 'numerical', 'integerOnly'=>true),
		array('content,choices', 'safe'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, userId, questionId, content', 'safe', 'on'=>'search'),
		);
	}

	public function behaviors(){
		return array(
		'CTimestampBehavior' => array(
			'class' => 'zii.behaviors.CTimestampBehavior',
			'createAttribute' => 'addTime',
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
			'question'=>array(self::BELONGS_TO,'Question','questionId'),
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
			'questionId' => 'Question',
			'content' => 'Content',
			'choices'=>'',
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
		$criteria->compare('questionId',$this->questionId);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function beforeSave(){
		//		if(parent::beforeSave()){
		$question = $this->question;
		$correctAnswerIds = array();
		foreach($question->correctChoices as $answer){
			$correctAnswerIds[] = $answer->id;
		}
		if($question->type=="multiple-choice"){
			if(is_array($this->choices)){
				$this->content = implode(',', $this->choices);
				$isCorrect = true;
				foreach($this->choices as $answerId){
					$isCorrect = in_array($answerId, $correctAnswerIds) && $isCorrect;
				}
				if(count($this->choices)==count($correctAnswerIds) && $isCorrect){
					$this->status = self::STATUS_CORRECT;
				}elseif(count($this->choices)<count($correctAnswerIds) && $isCorrect){
					$this->status = self::STATUS_PARTIAL_CORRECT;
				}else{
					$this->status = self::STATUS_WRONG;
				}
			}
			else {
				$this->content ="";
				$this->status = self::STATUS_WRONG;
			}

		}elseif($question->type=="single-choice"){
			$answer = Answer::model()->findByPk(intval($this->content));
			if($answer)
			$this->status = $answer->isCorrect ? self::STATUS_CORRECT : self::STATUS_WRONG;
		}

		if($this->status==self::STATUS_CORRECT) $this->score = $question->score;
		elseif($this->status==self::STATUS_PARTIAL_CORRECT) $this->score = $question->score/2;
		else $this->score = 0;

		return true;
	}


	public function afterSave(){
		$quizReport = $this->quizReport;
		$quiz = $this->question->quiz;
		
		if(!$quizReport){
			$quizReport = new QuizReport();
			$quizReport->userId = Yii::app()->user->id;
			$quizReport->quizId = $quiz->id;
		}
		$quizReport->refreshStat();

		$quiz->reportNum = $quiz->reportCount;
		$quiz->save();

		$questionReport = $this->questionReport;
		if(!$questionReport){
			$questionReport = new QuestionReport();
			$questionReport->questionId = $this->questionId;
		}
		$questionReport->refreshStat();

		$courseQuizReport = $this->courseQuizReport;
		if(!$courseQuizReport){
			$courseQuizReport = new CourseQuizReport();
			$courseQuizReport->courseId = $this->question->quiz->lesson->courseId;
			$courseQuizReport->userId = $this->userId;
		}
		$courseQuizReport->refreshStat();
	}

	public function getQuizReport(){
		return QuizReport::model()->findByAttributes(array('userId'=>$this->userId,'quizId'=>$this->question->quizId));
	}
	public function getQuestionReport(){
		return QuestionReport::model()->findByAttributes(array('questionId'=>$this->questionId));
	}
	public function getCourseQuizReport(){
		try{
			$courseId = $this->question->quiz->lesson->courseId;
			return CourseQuizReport::model()->findByAttributes(array('userId'=>$this->userId,'courseId'=>$courseId));		
		}catch (Exception $e){
		}
	}
	public function afterFind(){
		$question = $this->question;
		if($question->type=="multiple-choice" || $question->type =="single-choice"){
			$this->choices = array_filter(explode(',', $this->content));
		}
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Answer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

