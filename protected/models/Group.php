<?php

/**
 * This is the model class for table "group".
 *
 * The followings are the available columns in table 'group':
 * @property integer $id
 * @property string $name
 * @property integer $userId
 * @property integer $memberNum
 * @property integer $viewNum
 * @property string $fee
 *
 * The followings are the available model relations:
 * @property UserInfo $user
 * @property Lesson[] $lessons
 */
class Group extends EntityActiveRecord
{
	public $defaultFace = "images/group_face.jpg";

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{group}}';
	}
	
	
	/**
	* Returns the static model of the specified AR class.
	* @param string $className active record class name.
	* @return Group the static model class
	*/
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * 绑定behavior
	 * Enter description here ...
	 */
	function behaviors(){
		return array(
			'helper'=>array('class'=>'application.components.behaviors.GroupHelperBehavior'),
			'postable'=>array('class'=>'application.components.behaviors.PostableBehavior'),
			'memberable'=>array('class'=>'MemberableBehavior'),
			'categoryable'=>array('class'=>'CategoryableBehavior'),
			'attachment'=>array('class'=>'AttachmentsBehavior','items'=>array('face'=>array('exts'=>array('png','jpg','jpeg')))),
			'softDeleteActiveRecordBehavior' => array(
                                'class' => 'SoftDeleteBehavior',
								'relations'=>'posts',
             ),
			);
	}

	
	/**
	 * 小组人数改变
	 * Enter description here ...
	 * @param unknown_type $event
	 */		
	public function onMemberNumChanged($event){
		$this->raiseEvent("onMemberNumChanged",$event);
	}
	

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('name','filter','filter'=>'strip_tags'),
		array('name, userId,introduction,joinType, leaderTitle, memberTitle, adminTitle', 'required'),
		array('userId, memberNum, viewNum,categoryId', 'numerical', 'integerOnly'=>true),
		array('name,status', 'length', 'max'=>64),
		array('name','unique'),
		array('face', 'length', 'max'=>255),
		array('introduction','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),	
		//array('name', 'unique'),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, name, userId, memberNum, viewNum', 'safe', 'on'=>'search'),
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
			'superAdmin' => array(self::BELONGS_TO, 'UserInfo', 'userId'),
			'user' => array(self::BELONGS_TO, 'UserInfo', 'userId'),
		
		//	'lessons' => array(self::HAS_MANY, 'Lesson', 'id','order'=>'weight asc,addTime asc'),
//			'lessonCount' =>array(self::STAT,'Lesson','id'),
//			'category'=>array(self::BELONGS_TO,'GroupCategory','id'),

		/*
		 * added by lsy 20130807
		 * 课程与话题的关系
		 */
			'posts' => array(self::HAS_MANY, 'Post', 'groupId',
					'order'=>'addTime DESC'),
		/*
		 * added by lsy 20130807
		 */			
			'members'=>array(self::MANY_MANY,'UserInfo','ew_group_member(groupId,userId)','order'=>' members_members.role="superAdmin" or members_members.role="admin" or members_members.role="member"'),
			'applicants'=>array(self::MANY_MANY,'UserInfo','ew_group_member(groupId,userId)','order'=>'applicants_applicants.addTime desc','condition'=>'applicants_applicants.role="questioned_applicant"'),
		
			'courses'=>array(self::MANY_MANY,'Course','ew_group_course(groupId,courseId)','order'=>'courses_courses.addTime desc'),
		
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('app','小组名号'),
			'userId' => Yii::t('app','创建者'),
			'categoryId'=>Yii::t('app','小组分类'),
			'memberNum' => Yii::t('app','学员'),
			'viewNum' => Yii::t('app','点击量'),
			'fee' => Yii::t('app','费用'),
			'face'=>Yii::t('app','封面图片'),
			'introduction'=>Yii::t('app','小组简介'),
			'addTime'=>Yii::t('app','添加时间'),
			'role'=>Yii::t('app','角色'),
			'joinType'=>Yii::t('app','加入方式'),
            'leaderTitle'   =>  Yii::t('app','创始人称号'),
            'memberTitle'   =>  Yii::t('app','成员称号'),
            'adminTitle'    =>  Yii::t('app','管理员称号'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($pageSize=10)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('memberNum',$this->memberNum);
		$criteria->compare('viewNum',$this->viewNum);
	//	$criteria->compare('fee',$this->fee,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
        		'pageSize'=>$pageSize,
		)
		));
	}
	protected function beforeSave(){
		if($this->face == $this->defaultFace)
			$this->face = "";
		return parent::beforeSave();
	}
	
	protected function afterFind(){
		if(!$this->face) $this->face = $this->defaultFace;
		return parent::afterFind();
	}

	public function getPageUrl(){
		return Yii::app()->createUrl('group/index/view',array('id'=>$this->id));
	}
	
    public function getXFace()
    {
        if (empty($this->face)) {
            return 'http://placehold.it/120x120';
        } else {
            return Yii::app()->baseUrl . '/' . $this->face;
        }
    }
}
