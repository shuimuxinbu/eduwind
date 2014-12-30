<?php

/**
 * This is the model class for table "rate".
 *
 * The followings are the available columns in table 'rate':
 * @property integer $id
 * @property integer $userId
 * @property string $title
 * @property string $content
 * @property integer $addTime
 * @property integer $upTime
 * @property integer $score
 * @property integer $rateableEntityId
 */
class Rate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{rate}}';
	}

	public $avgScore;
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('score,content', 'required'),
		array('userId, addTime, upTime, score, rateableEntityId', 'numerical', 'integerOnly'=>true),
		array('title', 'length', 'max'=>255),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, userId, title, content, addTime, upTime, content,score, rateableEntityId', 'safe', 'on'=>'search'),
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
			'user'=>array(self::BELONGS_TO,'UserInfo','userId'),
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
			'title' => Yii::t('app','标题'),
			'content' => Yii::t('app','评语'),
			'addTime' => 'Add Time',
			'upTime' => 'Up Time',
			'score' => Yii::t('app','评分'),
			'rateableEntityId' => 'Rateable Entity',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('upTime',$this->upTime);
		$criteria->compare('score',$this->score);
		$criteria->compare('rateableEntityId',$this->rateableEntityId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAvgScore($entityId){
		$result = Yii::app()->db->createCommand()
								->select('avg(score) as avgScore')
								->from('ew_rate')
								->where('rateableEntityId=:entityId', array(':entityId'=>$entityId))
								->queryRow();
		return $result['avgScore'];
	}

    public function getCourse()
    {
        $Course = Course::model()->findByAttributes(
            array(
                'entityId'  =>  $this->rateableEntityId,
            )
        );
        return $Course;
    }
}
