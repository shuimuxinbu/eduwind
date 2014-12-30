<?php

/**
 * This is the model class for table "ew_question_report".
 *
 * The followings are the available columns in table 'ew_question_report':
 * @property integer $id
 * @property integer $questionId
 * @property integer $memberNum
 * @property string $partialCorrectRate
 * @property string $wrongRate
 * @property string $correctRate
 * @property integer $aNum
 * @property integer $bNum
 * @property integer $cNum
 * @property integer $dNum
 * @property integer $eNum
 * @property integer $fNum
 */
class QuestionReport extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{question_report}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('questionId', 'required'),
			array('questionId, memberNum, aNum, bNum, cNum, dNum, eNum, fNum', 'numerical', 'integerOnly'=>true),
			array('partialCorrectRate, wrongRate, correctRate', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, questionId, memberNum, partialCorrectRate, wrongRate, correctRate, aNum, bNum, cNum, dNum, eNum, fNum', 'safe', 'on'=>'search'),
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
			'questionId' => 'Question',
			'memberNum' => 'Member Num',
			'partialCorrectRate' => 'Partial Correct Rate',
			'wrongRate' => 'Wrong Rate',
			'correctRate' => 'Correct Rate',
			'aNum' => 'A Num',
			'bNum' => 'B Num',
			'cNum' => 'C Num',
			'dNum' => 'D Num',
			'eNum' => 'E Num',
			'fNum' => 'F Num',
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
		$criteria->compare('questionId',$this->questionId);
		$criteria->compare('memberNum',$this->memberNum);
		$criteria->compare('partialCorrectRate',$this->partialCorrectRate,true);
		$criteria->compare('wrongRate',$this->wrongRate,true);
		$criteria->compare('correctRate',$this->correctRate,true);
		$criteria->compare('aNum',$this->aNum);
		$criteria->compare('bNum',$this->bNum);
		$criteria->compare('cNum',$this->cNum);
		$criteria->compare('dNum',$this->dNum);
		$criteria->compare('eNum',$this->eNum);
		$criteria->compare('fNum',$this->fNum);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getMemberCount(){
		return 	QuestionResponse::model()->countByAttributes(array('questionId'=>$this->questionId));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QuestionReport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function refreshStat(){
		$this->memberNum = $this->memberCount;
		$this->aNum = $this->aCount;
		$this->bNum = $this->bCount;
		$this->cNum = $this->cCount;
		$this->dNum = $this->dCount;
		$this->eNum = $this->eCount;
		$this->fNum = $this->fCount;
		if($this->memberNum){
			$this->correctRate = $this->correctCount/$this->memberNum;
			$this->partialCorrectRate = $this->partialCorrectCount/$this->memberNum;
			$this->wrongRate = $this->wrongCount/$this->memberNum;
		}
		return $this->save();
	}
	
	public function getCorrectCount(){
		return QuestionResponse::model()->countByAttributes(array('questionId'=>$this->questionId,'status'=>QuestionResponse::STATUS_CORRECT));	
	}
	
	public function getPartialCorrectCount(){
		return QuestionResponse::model()->countByAttributes(array('questionId'=>$this->questionId,'status'=>QuestionResponse::STATUS_PARTIAL_CORRECT));	
	}
	
	public function getWrongCount(){
		return QuestionResponse::model()->countByAttributes(array('questionId'=>$this->questionId,'status'=>QuestionResponse::STATUS_WRONG));	
	}
	
	private function getAnswerIdByWeight($weight){
		$criteria = new CDbCriteria();
		$criteria->select = "id";
		$criteria->condition = "questionId=:questionId and weight=:weight";
		$criteria->params = array(':questionId'=>$this->questionId,':weight'=>$weight);
		$answer = Answer::model()->find($criteria);
		return $answer ? $answer->id : 0;
	}
	
	public function getAnswerByWeight($weight){
		$criteria = new CDbCriteria();
		$criteria->condition = "questionId=:questionId and weight=:weight";
		$criteria->params = array(':questionId'=>$this->questionId,':weight'=>$weight);
		$answer = Answer::model()->find($criteria);
		return $answer;		
	}
	public function countAnswer($answerId){
		$criteria = new CDbCriteria();
		$criteria->condition="questionId=:questionId and find_in_set('".$answerId."',content)";
		$criteria->params = array(':questionId'=>$this->questionId);
		$count = QuestionResponse::model()->count($criteria);
		return $count;
	}

	public function countByWeight($weight){
		$answerId = $this->getAnswerIdByWeight($weight);
		return $this->countAnswer($answerId);
	}
	public function getACount(){
		return $this->countByWeight(1);
	}

	public function getBCount(){
		return $this->countByWeight(2);
	}

	public function getCCount(){
		return $this->countByWeight(3);
	}

	public function getDCount(){
		return $this->countByWeight(4);		
	}

	public function getECount(){
		return $this->countByWeight(5);		
	}
	public function getFCount(){
		return $this->countByWeight(6);	
	}
	public function getAAnswer(){
		return $this->getAnswerByWeight(1);
	}

	public function getBAnswer(){
		return $this->getAnswerByWeight(2);
	}

	public function getCAnswer(){
		return $this->getAnswerByWeight(3);
	}

	public function getDAnswer(){
		return $this->getAnswerByWeight(4);		
	}

	public function getEAnswer(){
		return $this->getAnswerByWeight(5);		
	}
	public function getFAnswer(){
		return $this->getAnswerByWeight(6);	
	}
}
