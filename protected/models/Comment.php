<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $addTime
 * @property integer $rate
 * @property integer $userId

 * @property integer $referid
 */
class Comment extends EntityActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{comment}}';
	}

	public function behaviors(){
		return array(
			'voteable'=>array('class'=>'VoteableBehavior'),
			'commentHelper'=>array('class'=>'CommentHelperBehavior'),
		    'softDeleteActiveRecordBehavior' => array(
                                'class' => 'SoftDeleteBehavior',
             ),
             'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'addTime',
				'updateAttribute'=>null,
		)
		);
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, userId', 'required'),
			array('addTime,  userId, referId', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('content','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content, addTime,  userId,referId', 'safe', 'on'=>'search'),
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
			'commentableEntity'=> array(self::BELONGS_TO, 'Entity', 'commentableEntityId'),
			'user' => array(self::BELONGS_TO, 'UserInfo', 'userId'),
			'refer'=>array(self::BELONGS_TO,'Comment','referId'),
		
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'content' => 'Content',
			'addTime' => 'Add Time',
	//		'rate' => 'Rate',
			'userId' => 'User',
			'objectType' => 'Object Type',
			'referid' => 'Referid',
		);
	}

	/**
	 * comment事件
	 * Enter description here ...
	 * @param unknown_type $event
	 */		
	public function onRecommentAdded($event){
		$this->raiseEvent("onRecommentAdded",$event);
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('addTime',$this->addTime);
	//	$criteria->compare('rate',$this->rate);
		$criteria->compare('userId',$this->userId);

		$criteria->compare('referid',$this->referid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
