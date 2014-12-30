<?php

/**
 * This is the model class for table "course".
 *
 * The followings are the available columns in table 'course':
 * @property integer $courseId
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
class Course extends EntityActiveRecord
{
	//	public $publicFace = array();

		public $validDay;
		public $renewFee;
        private $lessonTable = "{{lesson}}";


	public $defaultFace = "images/course_face.png";
	const STATUS_OK = 1;
	const STATUS_HIDDEN = 2;


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Course the static model class
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
		return '{{course}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('subTitle','filter','filter'=>'strip_tags'),
		array('name, userId', 'required'),
		array('userId, isTop,memberNum,rateNum,viewNum,categoryId,validTime,validDay', 'numerical', 'integerOnly'=>true),
		array('fee,renewFee', 'numerical'),
		array('name', 'unique'),

		array('name', 'length', 'max'=>64),
		array('fee,renewFee', 'length', 'max'=>7),
		array('face,subTitle', 'length', 'max'=>255),
		array('targetStudent', 'length', 'max'=>1024),
		array('introduction','length','max'=>10240),
		array('introduction,targetStudent','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, name, userId, subTitle,memberNum,introduction, viewNum, fee', 'safe', 'on'=>'search'),
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
			'lessons' => array(self::HAS_MANY, 'Lesson', 'courseId','order'=>'weight asc,addTime asc'),
			'lessonCount' =>array(self::STAT,'Lesson','courseId','condition'=>'t.status='.Lesson::STATUS_PUBLIC),
			'category'=>array(self::BELONGS_TO,'Category','categoryId'),

		/*
		 * added by lsy 20130807
		 * 课程与话题的关系
		 */
		//		'posts' => array(self::HAS_MANY, 'Post', 'courseId',
		//				'order'=>'addTime DESC'),
		/*
		* added by lsy 20130807
		*/

		//		'rates'=>array(self::HAS_MANY,'CourseRate','courseId'),
		//'rateCount'=>array(self::STAT,'CourseRate','courseId'),
		//	'rateCount'=>array(self::STAT,'Comment','objectId','condition'=>'objectType="course"'),
		//	'averageRate'=>array(self::STAT,'Comment','objectId','select'=>'avg(rate)','condition'=>'objectType="course"'),
		//	'rate'=>array(self::STAT,'Comment','objectId','select'=>'avg(rate)','condition'=>'objectType="course"'),

		//	'students'=>array(self::MANY_MANY,'UserInfo','course_learn(courseId,userId)','order'=>'students_students.addTime desc'),

		//	'questions'=>array(self::HAS_MANY,'Question','courseId'),

		//'students'=>array(self::HAS_MANY,'CourseLearn','courseId'),
			'studentCount'=>array(self::STAT,'CourseMember','courseId','condition'=>'find_in_set("student",roles)'),
		//			'files'=>array(self::HAS_MANY,'CourseFile','courseId'),
		//			'fileCount'=>array(self::STAT,'CourseFile','courseId'),

		//		'groups'=>array(self::MANY_MANY,'Group','group_course(courseId,groupid)','order'=>'groups_groups.addTime desc'),


		/**
		 * added by lsy 20130821
		 * 课程与课程版本间的关系
		 */
		//		'introduction_revision' => array(self::HAS_MANY, 'CourseIntroductionRevision', 'courseId',
		//				'order' => 'versionid DESC',
		//	)
		/**
		* added by lsy 20130821
		*/

		);
	}



	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','课程'),
			'name' => Yii::t('app','课程名称'),
			'subTitle' => Yii::t('app','副标题'),
			'userId' => Yii::t('app','创建者'),
			'memberNum' => Yii::t('app','学员'),
			'viewNum' => Yii::t('app','点击量'),
			'fee' => Yii::t('app','价格'),
			'face'=>Yii::t('app','封面图片'),
			'targetStudent'=>Yii::t('app','目标人群'),
			'categoryId'=>Yii::t('app','课程分类'),
			'introduction'=>Yii::t('app','简介'),
			'addTime'=>Yii::t('app','添加时间'),
			'status'=>Yii::t('app','状态'),
			'validDay'=>Yii::t('app','有效期'),
		    'renewFee'=>Yii::t('app','续费价格'),
		);
	}
	/**
	 * 绑定behavior
	 */
	function behaviors() {
		return array(
				'helper'=>array('class'=>'CourseHelperBehavior'),
				'postable'=>array('class'=>'PostableBehavior'),
				'markable'=>array('class'=>'MarkableBehavior'),
		//				'memberable'=>array('class'=>'MemberableBehavior'),
				'commentable'=>array('class'=>'CommentableBehavior'),
				'applyabled'=>array('class'=>'ApplyableBehavior'),
				'rateabled'=>array('class'=>'RateableBehavior'),
				'collectabled'=>array('class'=>'CollectableBehavior'),
				'categoryable'=>array('class'=>'CategoryableBehavior'),
				'attachment'=>array('class'=>'AttachmentsBehavior','items'=>array('face'=>array('exts'=>array('png','jpg','jpeg')))),
			    'softDeleteActiveRecordBehavior' => array(
                                'class' => 'SoftDeleteBehavior',
		),
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
		$criteria->compare('fee',$this->fee,true);
		$criteria->order = 'isTop desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
        		'pageSize'=>$pageSize,
		)
		));
	}

	/**
	 * 检测是否已经可以发布
	 *	1 为课程上传图标
	 *	2 添加课程介绍
	 *	3 添加视频课时
	 */
	public function publishReady(){
		return  $this->lessonReady() &&  $this->introductionReady() && $this->faceReady();
	}

	/**
	 * 是否添加了视频
	 */
	public function lessonReady(){
		return  $this->lessonCount>0;
	}
	/**
	 * 检测是否已经添加课程介绍
	 */
	public function introductionReady(){
		return !empty($this->introduction);
	}
	/**
	 * 检测是否已经 添加课程图像
	 */
	public function faceReady(){
		return !empty($this->face);
	}
	/**
	 * 得到所有可能的tag并以字符串返回
	 */
	public function getAllTagsStr() {
		$allTags = $this->getAllTags();
		$alltagsstr = implode(",", $allTags);
		return $alltagsstr;
	}

	public function addLearn($params){
		$courseLearn = new CourseLearn;
		$courseLearn->courseId = $this->id;
		$courseLearn->userId = $params['userId'];
		$courseLearn->addTime = time();
		$courseLearn->status = $params['status'];
		if($courseLearn->save()) {
			$this->memberNum = $this->studentCount;
			$this->save();
			return $courseLearn;
		}
	}

	protected function beforeSave(){
		if($this->face == $this->defaultFace)
		$this->face = "";
		if($this->validDay!==null){
			$this->validTime = $this->validDay*24*3600;
		}
		if($this->renewFee == null || $this->renewFee == ''){
			$this->renewFee = $this->fee;
		}
		return parent::beforeSave();
	}

	protected function afterFind(){
		if(!$this->face) $this->face = $this->defaultFace;
		return parent::afterFind();
	}

	public function getPageUrl(){
		return Yii::app()->createUrl('//course/index/view',array('id'=>$this->id));
	}


	public function getXFace(){
		if(isset($this->face) && $this->face!='images/course_face.png')
		return Yii::app()->baseUrl.'/'.$this->face;
		else
		return 'http://placehold.it/270x200';
	}

    /**
     * 课程总课时长度
     */
    public function getCountDuration()
    {
        $time = Lesson::model()->findBySql("select sum(duration) as duration from $this->lessonTable where courseId={$this->id}")->duration;
        return $time ? $time : 0 ;

    }

    /**
     * 已经学习的课时长度
     */
    public function getLearnDuration()
    {
        $criteria = new CDbCriteria;
        $criteria->select   =   'sum(duration) duration';
        $criteria->join     =   'left join {{lesson_learn}} ll on ll.lessonId=t.id';
        $criteria->addCondition("ll.userId=" . Yii::app()->user->id);
        $criteria->addCondition("t.courseId={$this->id}");
        $time = Lesson::model()->find($criteria)->duration;
        return $time ? $time : 0 ;
    }

    /**
     * 课程总课时数据
     */
    public function getLessonNum()
    {
        $num = Lesson::model()->countByAttributes(
            array(
                'courseId'  =>  $this->id,
            )
        );
        return $num ? (int) $num : 0 ;
    }

    /**
     *
     */
    public function getLearnLessonNum()
    {
        $criteria = new CDbCriteria;
        $criteria->join = 'left join {{lesson}} l on t.lessonId=l.id';
        $criteria->addcondition("l.courseId={$this->id}");
        $criteria->addcondition('t.userId=' . Yii::app()->user->id);

        $num = LessonLearn::model()->count(
            $criteria
        );
        return $num ? (int) $num : 0 ;
    }
}
