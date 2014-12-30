<?php

/**
 * This is the model class for table "ew_course_member".
 *
 * The followings are the available columns in table 'ew_course_member':
 * @property integer $id
 * @property integer $orderId
 * @property integer $startTime
 * @property integer $endTime
 * @property integer $courseId
 * @property integer $userId
 * @property string $roles
 * @property integer $status
 */
class CourseMember extends CActiveRecord
{
	const 	STATUS_OK=1;
	const 	STATUS_EXPIRED=2;
	const   STATUS_NOT_PAY=3;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{course_member}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('startTime', 'required'),
			array('orderId, startTime, endTime, courseId, userId,status', 'numerical', 'integerOnly'=>true),
			array('roles', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, orderId, startTime, endTime, courseId, userId, roles,status', 'safe', 'on'=>'search'),
		);
	}
		/**
	 * 绑定behavior
	 */
	function behaviors() {
		return array(
				'roles'=>array('class'=>'RolesBehavior'),
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
			'user'=>array(self::BELONGS_TO,'UserInfo','userId'),
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
			'orderId' => 'Order',
			'startTime' => 'Start Time',
			'endTime' => 'End Time',
			'courseId' => 'Course',
			'userId' => Yii::t('app','用户'),
			'roles' => 'Roles',
			'arrRoles'=>Yii::t('app','角色组'),
		    'status'=>'status',
		
		);
	}
	// added by liang
	public function beforeSave(){
		if($this->isNewRecord){
			$this->status = self::STATUS_OK;
		}
		return parent::beforeSave();
	}
	
	//  added by wzh
	public function afterFind(){
		$this->refreshStatus();
	}
	
	public function afterDelete(){
		$this->refreshCourse();
	}
	
	public function afterSave(){
		$this->refreshCourse();
	}
	
	//  added by wzh
	protected  function refreshStatus(){
		// status=1 表示未过期；2表示过期 ;3表示未付费
		if($this->endTime==0){
			return;
		}
		if(time()>$this->endTime){
			$this->status=self::STATUS_EXPIRED;
			$this->save();
		}
	}

	protected function refreshCourse(){
		$course = Course::model()->findByPk($this->courseId);
		if(isset($course->studentNum)){
			//$course->update(array('studentNum'=>$course->studentCount));
			$course->studentNum = $course->studentCount;
			$course->save();
		}
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
		$criteria->compare('orderId',$this->orderId);
		$criteria->compare('startTime',$this->startTime);
		$criteria->compare('endTime',$this->endTime);
		$criteria->compare('courseId',$this->courseId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('roles',$this->roles,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	//  modified by wzh
	public function isValid(){
		//	if(!$this->getPrimaryKey()) return false;
		//	if($this->startTime>0 && $this->endTime==0) return true;
		//	else if($this->endTime<time()) return false;
		//	return true;
        if($this->status == self::STATUS_OK){
        	return true;
        }else if($this->status == self::STATUS_EXPIRED || $this->status == self::STATUS_NOT_PAY){
        	return false;
        }
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CourseMember the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
