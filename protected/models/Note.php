<?php

/**
 * This is the model class for table "note".
 *
 * The followings are the available columns in table 'note':
 * @property integer $id
 * @property integer $userId
 * @property integer $noteableEntityId
 * @property string $accessControl
 * @property string $title
 * @property string $content
 * @property integer $addTime
 * @property integer $upTime
 * @property integer $entityId
 */
class Note extends EntityActiveRecord
{
	public $siblingCount;
	
	public $courseId;
	
		
	public $lessonId;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{note}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, noteableEntityId', 'required'),
			array('userId, noteableEntityId, addTime, upTime, entityId', 'numerical', 'integerOnly'=>true),
			array('accessControl', 'length', 'max'=>32),
			array('title', 'length', 'max'=>255),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userId, noteableEntityId, accessControl, title, content, addTime, upTime, entityId', 'safe', 'on'=>'search'),
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
			'userId' => Yii::t('app','作者'),
			'noteableEntityId' => Yii::t('app','对象'),
			'accessControl' => Yii::t('app','访问控制'),
			'title' => Yii::t('app','标题'),
			'content' => Yii::t('app','内容'),
			'addTime' => Yii::t('app','添加时间'),
			'upTime' => Yii::t('app','更新时间'),
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('noteableEntityId',$this->noteableEntityId);
		$criteria->compare('accessControl',$this->accessControl,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('upTime',$this->upTime);
		$criteria->compare('entityId',$this->entityId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Note the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
