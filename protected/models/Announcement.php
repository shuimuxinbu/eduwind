<?php

/**
 * This is the model class for table "ew_announcement".
 *
 * The followings are the available columns in table 'ew_announcement':
 * @property integer $id
 * @property integer $courseId
 * @property string $content
 * @property integer $addTime
 * @property integer $upTime
 */
class Announcement extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{announcement}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('courseId, content, addTime', 'required'),
			array('courseId, addTime, upTime', 'numerical', 'integerOnly'=>true),
            array('content', 'filter', 'filter'=>array($obj=new CHtmlPurifier(), 'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, courseId, content, addTime, upTime', 'safe', 'on'=>'search'),
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
			'course'=>array(self::BELONGS_TO,'Course','courseId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'courseId' => Yii::t('app','课程ID'),
			'content' => Yii::t('app','内容'),
			'addTime' => Yii::t('app','添加时间'),
			'upTime' => Yii::t('app','更新时间'),
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('upTime',$this->upTime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Announcement the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
