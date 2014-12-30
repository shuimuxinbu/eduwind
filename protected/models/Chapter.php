<?php

/**
 * This is the model class for table "ew_chapter".
 *
 * The followings are the available columns in table 'ew_chapter':
 * @property integer $id
 * @property integer $courseId
 * @property integer $userId
 * @property integer $weight
 * @property integer $number
 * @property integer $lessonNum
 * @property string $title
 */
class Chapter extends CActiveRecord
{
	public $maxWeight;
	public $maxNumber;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{chapter}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('courseId, userId, title', 'required'),
		array('courseId, userId, weight, number, lessonNum', 'numerical', 'integerOnly'=>true),
		array('title', 'length', 'max'=>255),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, courseId, userId, weight, number, lessonNum, title', 'safe', 'on'=>'search'),
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
			'lessons'=>array(self::HAS_MANY,'Lesson','chapterId','order'=>'weight asc'),
			'course'=>array(self::BELONGS_TO,'Course','courseId'),
		);
	}

	public function refreshAllNumbers($courseId){
		$chapters = Chapter::model()->findAllByAttributes(array('courseId'=>intval($courseId)),array('order'=>'weight asc'));
		$count = count($chapters);
		for($i=0;$i<$count;$i++){
			//$chapters[$i]->update(array('number'=>$i+1));
			$chapters[$i]->number = $i+1;
			$chapters[$i]->save();
		}
	}

	public function behaviors(){
		return array(
             'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'addTime',
				'updateAttribute'=>null,
		)
		);
	}

	public function beforeSave(){
		if(!$this->weight || !$this->number){
			$criteria = new CDbCriteria();
			$criteria->condition = "courseId=".intval($this->courseId);
			$criteria->select = "max(weight) as maxWeight,max(number) as maxNumber";
			$chapter= self::model()->find($criteria);
			$lesson = Lesson::model()->find($criteria);
		}
			if(!$this->weight){
				if(!$chapter && !$lesson){
					$this->weight = 1;					
				}else if(!$lesson){
					$this->weight = $chapter->maxWeight+1;			
				}elseif(!$chapter){
					$this->weight = $lesson->maxWeight+1;			
				}else{
					$this->weight = max(array($chapter->maxWeight,$lesson->maxWeight))+1;
				}
			}
			if(!$this->number){
				if($chapter){
					$this->number = $chapter->maxNumber+1;
				}else{
					$this->number = 1;
				}
			}
		
		return parent::beforeSave();
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'courseId' => 'Course',
			'userId' => 'User',
			'weight' => 'Weight',
			'number' => 'Number',
			'lessonNum' => 'Lesson Num',
			'title' => Yii::t('app','标题'),
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('number',$this->number);
		$criteria->compare('lessonNum',$this->lessonNum);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Chapter the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
