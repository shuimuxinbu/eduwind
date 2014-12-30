<?php

/**
 * This is the model class for table "ew_lesson_chat".
 *
 * The followings are the available columns in table 'ew_lesson_chat':
 * @property integer $id
 * @property integer $lessonId
 * @property integer $userId
 * @property double $playTime
 * @property integer $fontSize
 * @property integer $color
 * @property integer $mode
 * @property integer $addTime
 * @property string $content
 */
class LessonChat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lesson_chat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lessonId, userId, fontSize, color, mode, addTime', 'numerical', 'integerOnly'=>true),
			array('playTime', 'numerical'),
			array('content', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lessonId, userId, playTime, fontSize, color, mode, addTime, content', 'safe', 'on'=>'search'),
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
			'lessonId' => 'Lesson',
			'userId' => 'User',
			'playTime' => 'Play Time',
			'fontSize' => 'Font Size',
			'color' => 'Color',
			'mode' => 'Mode',
			'addTime' => 'Add Time',
			'content' => 'Content',
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
		$criteria->compare('lessonId',$this->lessonId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('playTime',$this->playTime);
		$criteria->compare('fontSize',$this->fontSize);
		$criteria->compare('color',$this->color);
		$criteria->compare('mode',$this->mode);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LessonChat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
