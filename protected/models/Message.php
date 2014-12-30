<?php

/**
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property integer $messageid
 * @property integer $fromUserId
 * @property integer $toUserId
 * @property string $content
 * @property integer $addTime
 *
 * The followings are the available model relations:
 * @property UserInfo $fromUser
 * @property UserInfo $toUser
 */
class Message extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Message the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{message}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('fromUserId, toUserId, content', 'required'),
		array('fromUserId, toUserId, addTime', 'numerical', 'integerOnly'=>true),
		array('content','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('messageid, fromUserId, toUserId, content, addTime', 'safe', 'on'=>'search'),
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
			'fromUser' => array(self::BELONGS_TO, 'UserInfo', 'fromUserId'),
			'toUser' => array(self::BELONGS_TO, 'UserInfo', 'toUserId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'messageid' => 'Messageid',
			'fromUserId' => Yii::t('app','发信人'),
			'toUserId' => Yii::t('app','收信人'),
			'content' => Yii::t('app','内容'),
			'addTime' => Yii::t('app','时间'),
		);
	}
	/**
	 * $userId2发给$userId1而$userId1未读的私信,如果userId2为0，即返回$userId1所有未读的私信
	 * Enter description here ...
	 * @param unknown_type $userId1
	 * @param unknown_type $userId2
	 */
	public function countUnchecked($userId1,$userId2=0){
		if($userId2){
			return Message::model()->count(array('condition'=>'isChecked=0 and toUserId=:userId1 and fromUserId=:userId2',
											'params'=>array(':userId1'=>$userId1,':userId2'=>$userId2)));
		}else{
			return Message::model()->count(array('condition'=>'isCHecked=0 and toUserId=:userId',
											'params'=>array(':userId'=>$userId1)));		
		}
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('messageid',$this->messageid);
		$criteria->compare('fromUserId',$this->fromUserId);
		$criteria->compare('toUserId',$this->toUserId);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('addTime',$this->addTime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
