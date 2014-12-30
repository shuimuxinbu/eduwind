<?php

/**
 * This is the model class for table "entity".
 *
 * The followings are the available columns in table 'entity':
 * @property integer $id
 * @property string $type
 */
class Entity extends CActiveRecord
{
	private $_model;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{entity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
		);
	}
	/**
	 * 
	 */
	public function typeLabels(){
		return array(
			'group'=>Yii::t('app','小组'),
			'post'=>Yii::t('app','话题'),
			'comment'=>Yii::t('app','评论'),
			'question'=>Yii::t('app','提问'),
			'answer'=>Yii::t('app','回答'),
			'course'=>Yii::t('app','课程'),
			'lesson'=>Yii::t('app','课时'),
		);
	}
	/**
	 * 获取该entity所指向的$model
	 */
	public function getModel(){
		if(!$this->_model){
			$modelClass = ucfirst($this->type);
			$this->_model = call_user_func(array($modelClass,'model'))->findByAttributes(array('entityId'=>$this->getPrimaryKey()));
		}
		return $this->_model;
	}
	
	/**
	 * 返回entity的model的title，作发消息，动态用
	 * Enter description here ...
	 */
	public function getTitle(){
		$model = $this->getModel();
		if(isset($model->title)) 
			return $model->title;
		else if(isset($model->name)) 
			return $model->name;
		else if(isset($model->content)) 
			return mb_substr($model->content, 0,20);
		else if(isset($model->description)) 
			return mb_substr(strip_tags($model->description));
		else 
			return Yii::t('app',"点击查看");
		
	}
	/**
	 * 返回group，post等type对应的名称
	 */
	public function getTypeLabel(){
		$labels = $this->typeLabels();
		if(isset($labels[$this->type])) return $labels[$this->type];
		return $this->type;
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
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Entity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
