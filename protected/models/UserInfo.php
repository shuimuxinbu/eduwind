<?php

/**
 * This is the model class for table "user_info".
 *
 * The followings are the available columns in table 'user_info':
 * @property integer $userId
 * @property string $email
 * @property string $name
 * @property integer $isAdmin
 * @property integer $addTime
 * @property integer $upTime
 *
 * The followings are the available model relations:
 * @property Course[] $courses
 */
class UserInfo extends EntityActiveRecord
{
	public  $face_48;
	public $defaultFace = "images/user_face.jpg";
	public $bestAnswer;
	public $_roles;

	const STATUS_CREATED = 0;
	const STATUS_OK = 1;
	CONST STATUS_VERIFYING = 2;
	CONST STATUS_FROZENED = 3;
	
	//	public $answerVoteupCount;
	/**
	* Returns the static model of the specified AR class.
	* @param string $className active record class name.
	* @return UserInfo the static model class
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
		return '{{user_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('name,email,bio','filter','filter'=>'strip_tags'),
		array('email, name,addTime, upTime', 'required'),
		array('isAdmin, addTime, upTime,rennId', 'numerical', 'integerOnly'=>true),
		array('name,email','unique'),
		array('email, name', 'length', 'max'=>64),
		array('verifyCode','length','max'=>32),
		array('introduction,status,verifyCode','type','type'=>'string','allowEmpty'=>true),
		array('face,bio', 'length', 'max'=>255),
		array('introduction,bio,name,verifyCode','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, email, name,bio, isAdmin, addTime,roles, upTime', 'safe', 'on'=>'search'),
		);
	}

	public function behaviors(){
		return array(
			'followable'=>array('class'=>'FollowableBehavior',
								'autoFollow'=>false,
								'userIdAttribute'=>"id"),	
			'roles'=>array('class'=>'RolesBehavior'),
		//	'attachments'=>array('class'=>'AttachmentsBehavior','attributes'=>array('face')),
			'attachments'=>array('class'=>'AttachmentsBehavior','items'=>array('face'=>array('exts'=>array('png','jpg','jpeg')))),
		    'softDeleteActiveRecordBehavior' => array(
                                'class' => 'SoftDeleteBehavior',
             ),
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
			'courses' => array(self::HAS_MANY, 'Course', 'userId'),
			'coursesOk' => array(self::HAS_MANY, 'Course', 'userId','condition'=>"coursesOk.status='ok'"),
			'notices'=>array(self::HAS_MANY,'Notice','userId','order'=>'notices.addTime desc'),
			'noticesUnisChecked'=>array(self::HAS_MANY,'Notice','userId','condition'=>'isChecked=0','order'=>'noticesUnisChecked.addTime desc'),
			
			'messagesReceived'=>array(self::HAS_MANY,'Message','toUserId'),
			'messagesSended'=>array(self::HAS_MANY,'Message','fromUserId'),
			'fanCount'=>array(self::STAT,'UserFollow','followed_userId'),

			'unisCheckedMessageCount'=>array(self::STAT,'Message','toUserId','condition'=>'isChecked=0'),
			'unisCheckedNoticeCount'=>array(self::STAT,'Notice','userId','condition'=>'isChecked=0'),
			'oauth'=>array(self::HAS_ONE,'Oauth','userId'),

			'contacts' => array(self::HAS_MANY, 'Contact', 'userId','order'=>'convert(contacts.name using GBK) desc'),
			
			'questions' => array(self::HAS_MANY, 'Question', 'userId'),

			'answers' => array(self::HAS_MANY, 'Answer', 'userId'),
		//			'roles' => array(self::HAS_ONE, 'AuthAssignment', 'userid'),//create new property roles
			'courseCount'=>array(self::STAT,'Course','userId','condition'=>'status="ok"'),
			'questionCount'=>array(self::STAT,'Question','userId'),
			'answerCount'=>array(self::STAT,'Answer','userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'face' => Yii::t('app','头像'),
			'name' => Yii::t('app','用户名'),
			'isAdmin' => Yii::t('app','是否管理员'),
			'addTime' => Yii::t('app','加入时间'),
			'bio'=>Yii::t('app','一句话介绍'),
			'status'=>Yii::t('app','状态'),
			'roles'=>Yii::t('app','用户组'),
			'arrRoles'=>Yii::t('app','用户组'),
			'introduction'=>Yii::t('app','自我介绍'),
			'upTime' => Yii::t('app','上次登录'),
		);
	}

	public function getBestAnswer(){
		//$sql = "select a.* from answer a left join answer_vote v on a.id=v.answerid where a.userId= 1 and v.value>0 group by a.id order by count(*) desc,a.addTime desc limit 1";
		$sql = "select a.* from ew_answer a left join  ew_entity e on a.voteableEntityId=e.id left join ew_vote v on e.id=v.voteableEntityId where a.userId= ".$this->id." and v.value>0 order by a.addTime desc limit 1";
		$answer = Answer::model()->findBySql($sql);
		return $answer;
	}

	public function getAnswerVoteupCount(){
		$sql = "select v.* from ew_answer_vote v left join ew_answer a on v.answerid=a.id where a.userId=$this->id and v.value>0";
		$vs = AnswerVote::model()->findAllBySql($sql);
		return count($vs);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($pageSize=100)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('isAdmin',$this->isAdmin);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('upTime',$this->upTime);
		//use roles property
		//		$criteria->compare('roles.itemname', $this->roles, true, 'OR');
		//		$criteria->with = array('roles');


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$pageSize,
		),
		));
	}

	/*	public function getRolesAsString(){
		$roles=Rights::getAssignedRoles($this->id); // check for single role
		$arrRoles = array();
		foreach($roles as $role){
		$arrRoles[] = $role->name;
		}
		$this->_roles = implode(',', $arrRoles);
		return $this->_roles;
		}*/
	public function getRoles(){
		return array_keys(Rights::getAssignedRoles($this->id));
	}
	public function setRoles($roles){
//		$authorizer = Yii::app()->getModule("rights")->getAuthorizer();
		if(!is_array($roles)) return false;
		foreach($this->roles as $role){
			Rights::revoke($role, $this->id);
		}
		foreach($roles as $role){
			Rights::assign($role, $this->id);
		}
		return true;
		
	}
	public function getRolesAsString(){
		/*		$roles=Rights::getAssignedRoles($this->id); // check for single role
		 $arrRoles = array();
		 foreach($roles as $role){
			$arrRoles[] = $role->name;
			}*/
		if(is_array($this->roles))
		return implode(',', $this->roles);
		else return "";
		//		return $this->_roles;
	}
	/**
	 * 返回所有系统管理员
	 */
	public static function getAllAdmins(){
//		return UserInfo::model()->findAllByAttributes(array('isAdmin'=>1));
		$adminNames = Yii::app()->getModule("rights")->getAuthorizer()->getSuperusers();
	//	error_log(print_r($adminNames,true));
		$admins = array();
		foreach($adminNames as $email){
			$user =  UserInfo::model()->findByAttributes(array('email'=>$email));
			if($user)$admins[] = $user;
		}
	//	error_log(print_r($admins,true));
		return $admins;
	}

	protected function beforeSave(){
		if($this->face == $this->defaultFace)
			$this->face = "";
		return parent::beforeSave();
	}
	public function noEmail(){
		//如果还没有填写email
		if(preg_match('/RRId.*daxidao\.com/is',$this->email)){
			return true;
		}
		return false;
	}



	protected function afterFind(){
		//if(!$this->face) $this->face = $this->defaultFace;
		$this->face_48 = $this->face && DxdUtil::xImage($this->face,48,48) ? Yii::app()->baseUrl."/".DxdUtil::xImage($this->face,48,48) : "http://placehold.it/48x48";
		//	if($this->noEmail()) $this->email = "";
		return parent::afterFind();
	}


	/*	public function getUserRoleName($id=Null) {
		if(is_null($id))
		{$id=$this->id;}
		if ($AuthassignmentModel=Authassignment::Model()->findByAttributes(array('userid'=>$id))) {
		$roleName = $AuthassignmentModel->itemname;
		}

		return(isset($roleName)) ? ($roleName) : "-----";
		}

		*/
	public function getRolesAsListData()
	{
		$roles = Yii::app()->authManager->getRoles();
		return CHtml::listData($roles,'name','name');
	}
	
	public function getPageUrl(){
		return Yii::app()->createUrl('//u/index',array('id'=>$this->id));
	}
    
    /**
     * 用户头像
     */
    public function getXFace()
    {
        if($this->face):
            return Yii::app()->baseUrl."/".$this->face;
        else:
            return  Yii::app()->baseUrl."/".$this->defaultFace;
        endif;

    }
	
}
