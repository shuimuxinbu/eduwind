<?php

/**
 * This is the model class for table "member".
 *
 * The followings are the available columns in table 'member':
 * @property integer $id
 * @property integer $userId
 * @property integer $memberableEntityId
 * @property integer $addTime
 * @property integer $upTime
 * @property string $roles
 */
class Member extends CActiveRecord
{
	private $_arrRoles;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{member}}';
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
		array('userId, memberableEntityId, addTime, upTime', 'numerical', 'integerOnly'=>true),
		array('roles', 'length', 'max'=>64),
		array('arrRoles','type','type'=>'array','allowEmpty'=>false),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('id, userId, memberableEntityId, addTime, upTime, roles', 'safe', 'on'=>'search'),
		array('memberableEntityId+userId','ext.uniqueMultiColumnValidator.uniqueMultiColumnValidator'),
			
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' => 'User',
			'memberableEntityId' => 'Memberable Entity',
			'addTime' => 'Add Time',
			'upTime' => 'Up Time',
			'roles' => Yii::t('app','用户组'),
			'arrRoles'=>Yii::t('app','用户组'),
		);
	}


	/**
	 * 是否在某一个用户组中
	 * @param array $targetRoles
	 */
	public function inRoles($targetRoles){
		foreach($this->arrRoles as $item){
			if(in_array($item, $targetRoles)) return true;
		}
		return false;
	}


	/**
	 * 设置用户角色
	 * @param array/string $targetRoles
	 */
	public function setArrRoles($targetRoles){
		if(!$targetRoles){ $this->_arrRoles = array();}
		else if(is_array($targetRoles)){
			$this->_arrRoles = $targetRoles;
		}
		$this->roles = implode(',',$this->_arrRoles);
		
	}

	/**
	 * 获取用户角色数组
	 * @param array/string $targetRoles
	 */
	public function getArrRoles(){
		if($this->roles){		
			$this->_arrRoles = explode(',',$this->roles);
			return $this->_arrRoles;
		}else{
			return array();
		}
	}

	/**
	 * 获取本member中角色权限不比$userId低的角色,如果操作者不是同一组织的成员，则返回本成员所有roles
	 * Enter description here ...
	 * @param unknown_type $userId
	 */
	public function getNoLowerRoles(){
		if(Yii::app()->user->checkAccess('admin')) return array();
		$userId = Yii::app()->user->id;
		$operateMember = Member::model()->findByAttributes(array('userId'=>$userId,'memberableEntityId'=>$this->memberableEntityId));
		$objectMember = $this->isNewRecord ? $this : Member::model()->findByPk($this->id);
		if($operateMember){
			$result = array();
			if($objectMember->inRoles(array('superAdmin'))) $result[] = 'superAdmin';
			//if($operateMember->inRoles(array('superAdmin'))) return array('superAdmin');
			if($operateMember->inRoles(array('admin'))){
				if($objectMember->inRoles(array('admin'))) $result[]='admin';
			}
			return $result;
		}
		return $objectMember->arrRoles;

	}
	/**
	 * 不允许操作权限级别比操作者搞的role
	 */
	protected function beforeSave(){
		//var_dump($this->_arrRoles);
		
		$noLowerRoles = $this->getNoLowerRoles();
		$this->arrRoles = array_merge($this->arrRoles,$noLowerRoles);
		$this->arrRoles = array_unique($this->arrRoles);
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('memberableEntityId',$this->memberableEntityId);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('upTime',$this->upTime);
		$criteria->compare('roles',$this->roles,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Member the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
