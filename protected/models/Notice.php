<?php

/**
 * This is the model class for table "notice".
 *
 * The followings are the available columns in table 'notice':
 * @property integer $id
 * @property integer $userId
 * @property string $data
 * @property string $type
 * @property integer $addTime
 *
 * The followings are the available model relations:
 * @property UserInfo $user
 */
class Notice extends CActiveRecord
{
	public $viewFile;
	public $viewData;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Notice the static model class
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
		return '{{notice}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('userId', 'required'),
		array('userId, addTime', 'numerical', 'integerOnly'=>true),
		array('data', 'length', 'max'=>1024),
		array('type', 'length', 'max'=>255),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, userId, data, type, addTime', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'UserInfo', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Noticeid',
			'userId' => 'Userid',
			'data' => 'Data',
			'type' => 'Type',
			'addTime' => 'Addtime',
		);
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

		$criteria->compare('id',$this->id);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('addTime',$this->addTime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function behaviors(){
		return array(
			'helper'=>array('class'=>'NoticeHelperBehavior'),
		);
	}
	/**
	 * 发送系统提醒消息
	 * @param iint $userId 消息接收人
	 * @param string $type 消息类型，用于确定消息填充的template
	 * @param array $data 消息填充所需要的数据
	 */
	public static function send($userId,$type,$data){
		$notice = new Notice;
		$notice->type = $type;
		$notice->setData($data);
		$notice->userId = $userId;
		return $notice->save();
	}
	/**
	 * @overide beforeSave()
	 */
	protected function beforeSave(){
		$this->addTime = time();
		return parent::beforeSave();
	}

	public function setData($data){
		$this->data = addslashes(serialize($data));
	}
	public function getData(){
		return unserialize(stripslashes($this->data));
	}

	/**
	 * 获取未读提醒总数
	 * @param unknown_type $userId
	 * @return 关联数组，key为提醒类型，
	 */
	public function countTypeUncheckeds($userId){
		$sql = "select count(*) as num,type from ew_notice where isChecked=0 and userId=$userId group by type";
		$raw = Yii::app()->db->createCommand($sql)->queryAll();
		$result = array();
		foreach($raw as $key=>$item){
			$result = array_merge($result,array($item['type']=>$item['num']));
		}
		return $result;
	}
	/**
	 * 获取所有未读提醒的总数
	 * @param unknown_type $userId
	 */
	public function countUnchecked($userId){
		$uncheckNums = $this->getUncheckedNumsByType($userId);
		if(is_array($uncheckNums)){
			return array_sum($uncheckNums);
		}
		return 0;
	}

}
