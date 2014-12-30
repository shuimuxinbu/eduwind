<?php

/**
 * This is the model class for table "event_base".
 *
 * The followings are the available columns in table 'event_base':
 * @property integer $id
 * @property integer $addTime
 * @property integer $upTime
 * @property integer $provinceId
 * @property string $name
 * @property string $gain
 * @property string $teacherIntroduction
 * @property string $why
 * @property string $description
 * @property string $targetPeople
 * @property string $photo
 * @property integer $userId
 * @property integer $categoryId
 * @property integer $entityId
 */
class EventBase extends EntityActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{event_base}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gain, teacherIntroduction, why, description, targetPeople, userId', 'required'),
			array('addTime, upTime, cityId,provinceId, userId, categoryId, entityId', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('photo', 'length', 'max'=>511),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, addTime, upTime, provinceId, name, gain, teacherIntroduction, why, description, targetPeople, photo, userId, categoryId, entityId', 'safe', 'on'=>'search'),
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
			'category'=>array(self::BELONGS_TO,'Category','categoryId','condition'=>'t.type="eventBase"'),
			'city'=>array(self::BELONGS_TO,'City','cityId'),
			'user'=>array(self::BELONGS_TO,'UserInfo','userId'),
			'events'=>array(self::HAS_MANY,'Event','baseId','order'=>'startTime asc')
		
		);
	}

	public function behaviors(){
		return array(
			'commentable'=>array('class'=>'CommentableBehavior'),
			'categoryable'=>array('class'=>'CategoryableBehavior'),
			'rateabled'=>array('class'=>'RateableBehavior'),
			'collectabled'=>array('class'=>'CollectableBehavior'),
			'attachments'=>array('class'=>'AttachmentsBehavior','attributes'=>array('photo')),
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'addTime' => 'Add Time',
			'upTime' => 'Up Time',
			'provinceId' => Yii::t('app','开课省份'),
			'cityId' => Yii::t('app','开课城市'),
			'name' => Yii::t('app','课程名称'),
			'gain' => Yii::t('app','学生在这堂课能收获什么'),
			'teacherIntroduction' => Yii::t('app','向学生介绍一下老师'),
			'why' => Yii::t('app','为什么开这门课'),
			'description' => Yii::t('app','课程介绍'),
			'targetPeople' => Yii::t('app','目标受众'),
			'photo' => Yii::t('app','封面图片'),
			'userId' => Yii::t('app','用户'),
			'categoryId' => Yii::t('app','课程分类'),
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
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('upTime',$this->upTime);
		$criteria->compare('provinceId',$this->provinceId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('gain',$this->gain,true);
		$criteria->compare('teacherIntroduction',$this->teacherIntroduction,true);
		$criteria->compare('why',$this->why,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('targetPeople',$this->targetPeople,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('categoryId',$this->categoryId);
		$criteria->compare('entityId',$this->entityId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventBase the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
