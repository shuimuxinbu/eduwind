<?php

/**
 * This is the model class for table "event".
 *
 * The followings are the available columns in table 'event':
 * @property integer $id
 * @property integer $baseId
 * @property integer $startTime
 * @property integer $endTime
 * @property integer $areaId
 * @property string $place
 * @property integer $userId
 * @property integer $fee
 * @property integer $peopleCapacity
 * @property string $contactPerson
 * @property string $contactPhone
 * @property string $contactEmail
 * @property string $contactQQ
 */
class Event extends EntityActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{event}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('baseId', 'required'),
			array('baseId, startTime, endTime, areaId, userId, fee, peopleCapacity', 'numerical', 'integerOnly'=>true),
			array('place', 'length', 'max'=>255),
			array('contactPerson, contactPhone, contactEmail, contactQQ', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, baseId, startTime, endTime, areaId, place, userId, fee, peopleCapacity, contactPerson, contactPhone, contactEmail, contactQQ', 'safe', 'on'=>'search'),
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
			'base'=>array(self::BELONGS_TO,'EventBase','baseId'),
			'user'=>array(self::BELONGS_TO,'UserInfo','userId'),
			'area'=>array(self::BELONGS_TO,'Area','areaId'),	
		);
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'baseId' => 'Base',
			'startTime' => Yii::t('app','开始时间'),
			'endTime' => Yii::t('app','结束时间'),
			'areaId' => Yii::t('app','县/区'),
			'place' => Yii::t('app','详细地址'),
			'userId' => 'User',
			'fee' => Yii::t('app','收费'),
			'peopleCapacity' => Yii::t('app','课堂容量'),
			'contactPerson' => Yii::t('app','联系人'),
			'contactPhone' => Yii::t('app','手机号码'),
			'contactEmail' => Yii::t('app','邮箱地址'),
			'contactQQ' => Yii::t('app','QQ号码'),
		);
	}
	
	public function behaviors(){
		return array(
			'memberable'=>array('class'=>'MemberableBehavior'),
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
		$criteria->compare('baseId',$this->baseId);
		$criteria->compare('startTime',$this->startTime);
		$criteria->compare('endTime',$this->endTime);
		$criteria->compare('areaId',$this->areaId);
		$criteria->compare('place',$this->place,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('peopleCapacity',$this->peopleCapacity);
		$criteria->compare('contactPerson',$this->contactPerson,true);
		$criteria->compare('contactPhone',$this->contactPhone,true);
		$criteria->compare('contactEmail',$this->contactEmail,true);
		$criteria->compare('contactQQ',$this->contactQQ,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Event the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
