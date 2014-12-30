<?php

/**
 * This is the model class for table "ew_question".
 *
 * The followings are the available columns in table 'ew_question':
 * @property integer $id
 * @property string $stem
 * @property string $type
 * @property string $choices
 * @property integer $quizId
 */
class Question extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{question}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stem','required'),
			array('quizId,weight', 'numerical', 'integerOnly'=>true),
			array('score', 'numerical'),
			array('stem', 'safe'),
			array('type', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, stem, quizId', 'safe', 'on'=>'search'),
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
			'quiz'=>array(self::BELONGS_TO,'Quiz','quizId'),
		//	'answer'=>array(self::HAS_ONE,'Answer','questionId'),
			'choices'=>array(self::HAS_MANY,'Answer','questionId','order'=>'choices.weight asc'),
			'correctChoices'=>array(self::HAS_MANY,'Answer','questionId','condition'=>'correctChoices.isCorrect=1','order'=>'correctChoices.weight asc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'stem' => Yii::t('app','题干'),
			'quizId' => 'Quiz',
			'score' => Yii::t('app','分值'),
		);
	}

	public function afterSave(){
		$this->quiz->questionNum = $this->quiz->questionCount;
		$this->quiz->save();
	}
	
	public function beforeSave(){
		if( $this->weight==0){
			$maxWeight = $this->model()->countByAttributes(array('quizId'=>$this->quizId));			
			$this->weight = $maxWeight+1;
		}
		return parent::beforeSave();
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
		$criteria->compare('stem',$this->stem,true);
		$criteria->compare('quizId',$this->quizId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Question the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function userResponse($userId){
		$response = QuestionResponse::model()->findByAttributes(array('questionId'=>$this->id,'userId'=>$userId));
		return $response;
	}
	
}
