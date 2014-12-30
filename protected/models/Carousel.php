<?php

/**
 * This is the model class for table "carousel".
 *
 * The followings are the available columns in table 'carousel':
 * @property integer $id
 * @property integer $addTime
 * @property string $path
 * @property string $url
 * @property integer $weight
 */
class Carousel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{carousel}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		//	array('url','required'),
			array('addTime, weight,courseId', 'numerical', 'integerOnly'=>true),
			array('path', 'length', 'max'=>255),
			array('url', 'length', 'max'=>1024),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, addTime, path, url, weight', 'safe', 'on'=>'search'),
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

	public function behaviors(){
		return array(		
			'attachments'=>array('class'=>'AttachmentsBehavior','items'=>array('path'=>array('exts'=>array('png','jpg','jpeg')))),
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
			'path' => Yii::t('app','图片'),
			'url' => Yii::t('app','链接地址（以http://开头）'),
			'weight' => 'Weight',
			'courseId'=>Yii::t('app','关联课程'),
		);
	}
	
	protected function beforeSave(){
		if($this->isNewRecord) $this->addTime = time();
				/**
		 * 强制图片只能修改，不能更换
		 */
		if(!$this->path){
			unset($this->path);
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
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('weight',$this->weight);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Carousel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
