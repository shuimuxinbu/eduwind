<?php

/**
 * This is the model class for table "ew_order".
 *
 * The followings are the available columns in table 'ew_order':
 * @property integer $id
 * @property string $status
 * @property string $subject
 * @property integer $produceEntityId
 * @property integer $userId
 * @property string $meansOfPayment
 * @property integer $addTime
 * @property integer $paidTime
 */
class Order extends CActiveRecord
{
	
	public $orderStatus;
	
	// 产生订单，等待订单付款
	const ORDER_WAIT_PAY = 1;
	// 订单已成功付款
	const ORDER_PAID = 2;
	// 订单付完款后，又取消
	const ORDER_CANCLLED = 3;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, subject, price,produceEntityId, userId', 'required'),
			array('produceEntityId, userId, addTime, paidTime', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>9),
			array('subject', 'length', 'max'=>255),
			array('meansOfPayment', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, status, subject, produceEntityId, userId, meansOfPayment, addTime, paidTime,statusLabel,user.name', 'safe', 'on'=>'search'),
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
			'user'=>array(self::BELONGS_TO,'UserInfo','userId')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','订单ID'),
			'status' => 'status',
		    'orderStatus' => Yii::t('app','订单状态'),
			'subject' => Yii::t('app','订单描述'),
			'produceEntityId' => 'Produce Entity',
			'userId' => 'userId',
		    'user.name'=>Yii::t('app','订单所属者'),
			'meansOfPayment' => 'Means Of Payment',
			'addTime' => Yii::t('app','创建时间'),
			'paidTime' => Yii::t('app','付费时间'),
		    'statusLabel' => Yii::t('app','订单状态'),
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
		$criteria->compare('status',$this->status,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('produceEntityId',$this->produceEntityId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('meansOfPayment',$this->meansOfPayment,true);
		$criteria->compare('addTime',$this->addTime);
//		$criteria->compare('paidTime',$this->paidTime);
//		$criteria->compare('statusLabel',$this->statusLabel);
//		$criteria->compare('user.name',$this->user->name);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	

	
	public function getStatusLabel(){
		$label = "";
		if($this->status == self::ORDER_WAIT_PAY){
			$label = Yii::t('app','等待订单付款');
		}else if($this->status == self::ORDER_PAID){
			$label ==Yii::t('app','订单已成功付款');
		}else{
			$label ==Yii::t('app','订单付完款后又退款');
		}
		return $label;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
