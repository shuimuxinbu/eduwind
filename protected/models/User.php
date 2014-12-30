<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $salt
 */
class User extends CActiveRecord
{
	private $_plainPassword;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'ew_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password', 'required'),
			array('email', 'length', 'max'=>64),
			array('password, salt', 'length', 'max'=>32),
			array('resetPassword,plainPassword', 'length', 'max'=>32),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, password, salt', 'safe', 'on'=>'search'),
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
			'id' => 'id',
			'email' => 'Email',
			'plainPassword' => Yii::t('app','密码'),
			'salt' => 'Salt',
		);
	}

	public function getPlainPassword(){
		return $this->_plainPassword;
	}
	public function setPlainPassword($plainPassword){
		$this->_plainPassword = $plainPassword;
		$this->salt = md5(rand());
		$this->password = $this->encryptPassword($plainPassword);
	}
	/**
	 * 比较密码，相符则返回true
	 * Enter description here ...
	 * @param unknown_type $plainPassword
	 */
	public function comparePassword($plainPassword){
		return $this->encryptPassword($plainPassword)==$this->password;
	}
	/**
	 * 加密
	 * @param unknown_type $plainPassword
	 */
	protected function encryptPassword($plainPassword){
		return md5($this->salt.$plainPassword);
	}
	/**
	*添加一个用户
	*/
	public function addUser($email,$password,$info=array()){
		$user = new User;
		$user->plainPassword = $password;
		$user->email = $email;
		//用户名不可缺少
		if($user->save()){
			$userInfo = new UserInfo;
			$userInfo->id = $user->getPrimaryKey();
			$userInfo->email = $user->email;
			$attributes = $userInfo->getAttributes();
			foreach($info as $k=>$v){
				if(in_array($k, $attributes)){
					$userInfo->$k = $v;
				}
			}
			$userInfo->addTime = time();
			if($userInfo->save()){
				return true;
			}else{
				$user->delete();
			}
		}
		return false;

	}
	/**
	 * 免密码登陆
	 */
	public function loginWithoutPassword(){
				//站内用户登录
			$identity=new UserIdentity($this->email,'somepassword');
			$identity->authenticate(true);

			if($identity->errorCode===UserIdentity::ERROR_NONE)
			{
				//$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
				return Yii::app()->user->login($identity, 0);
				//print_r(Yii::app()->user);
			}
			return false;
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}