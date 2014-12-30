<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property string $name
 * @property integer $parentId
 * @property string $type
 * @property integer $weight
 * @property integer $userId
 */
class Category extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('name,type','required'),
		array('parentId, weight, userId', 'numerical', 'integerOnly'=>true),
		array('name, type', 'length', 'max'=>64),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, name, parentId, type, weight, userId', 'safe', 'on'=>'search'),
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
			'parent' => array(self::BELONGS_TO, 'Category', 'parentId'),	
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('app','分类名'),
			'parentId' => 'Parent',
			'type' => 'Type',
			'weight' => Yii::t('app','次序'),
			'userId' => 'User',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parentId',$this->parentId);
		$criteria->compare('type',$this->type,true);
		//	$criteria->compare('weight',$this->weight);
		$criteria->compare('userId',$this->userId);
		$criteria->order = "weight asc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public  function afterDelete(){
		$className = ucfirst($this->type);
		
		if(class_exists($className)){
			$objects = call_user_func(array($className,'model'))->findAllByAttributes(array('categoryId'=>$this->getPrimaryKey()));
			foreach($objects as $object){
				$object->categoryId = 0;
				$object->save();
			}
		}
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
