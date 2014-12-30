<?php

/**
 * This is the model class for table "ew_lesson_doc".
 *
 * The followings are the available columns in table 'ew_lesson_doc':
 * @property integer $id
 * @property integer $lessonId
 * @property integer $fileId
 * @property string $description
 */
class LessonDoc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lesson_doc}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('description', 'required'),
			array('lessonId, fileId', 'numerical', 'integerOnly'=>true),
			array('description','length','max'=>4960),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lessonId, fileId, description', 'safe', 'on'=>'search'),
		);
	}
	public function behaviors(){
		return array(
			'uploadFile' => array('class' => 'UploadFileBehavior', 'items' =>array('fileId'=>array()))
		
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
			'file' => array(self::BELONGS_TO, 'UploadFile', 'fileId'),
			'lesson'=>array(self::BELONGS_TO, 'Lesson', 'lessonId'),
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
			'fileId' => Yii::t('app','资料文件'),
			'description' => Yii::t('app','资料说明'),
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
		$criteria->compare('fileId',$this->fileId);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LessonDoc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
