<?php

/**
 * This is the model class for table "lesson".
 *
 * The followings are the available columns in table 'lesson':
 * @property integer $id
 * @property string $title
 * @property integer $courseId
 * @property integer $weight
 * @property integer $addTime
 * @property integer $upTime
 * @property string $mediaId
 * @property string $mediaSource
 * @property string $mediaUri
 * @property string $mediaName
 */
class Lesson extends EntityActiveRecord
{
	public $_url;
	private $_oldMediaId;
	private $_oldMediaType;
	public $maxWeight;
	public $maxNumber;

	const STATUS_PUBLIC=1;
	const STATUS_HIDDEN=2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lesson}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('courseId,userId,title', 'required'),
			array('courseId, weight, status,addTime,isFree, chapterId,upTime,entityId,mediaId', 'numerical', 'integerOnly'=>true),
			array('title,mediaUri', 'length', 'max'=>255),
			array('introduction', 'length', 'max'=>25500),
			array('mediaType', 'length', 'max'=>32),
            array('duration', 'safe'),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
			array('id, title, courseId, weight, addTime, upTime, mediaId, mediaSource, mediaUri, mediaName', 'safe', 'on'=>'search'),
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
			'course' => array(self::BELONGS_TO, 'Course', 'courseId'),
			'user' => array(self::BELONGS_TO, 'UserInfo', 'userId'),
		//		'file' => array(self::BELONGS_TO,'UploadFile','mediaId'),
			'docs'=>array(self::HAS_MANY,'LessonDoc','lessonId'),
		//		'mediaLink'=>array(self::BELONGS_TO,'MediaLink','mediaId','condition'=>'mediaType="video"'),
		//	 	'quiz'=>array(self::BELONGS_TO,'Quiz','mediaId','on'=>'quiz.id=t1.mediaId'),
			);
	}

	public function getQuiz(){
		$criteria = new CDbCriteria;
		$criteria->join = "left join ew_lesson l on  l.mediaId=t.id";
		$criteria->condition = "l.mediaType='quiz' and l.id=".intval($this->id);
		$quiz = Quiz::model()->find($criteria);
		return $quiz;
	}
	public function getFile(){
		if($this->mediaType=="video" && $this->mediaId){
			return UploadFile::model()->findByPk($this->mediaId);
		}
	}
	
	public function getOldFile(){
		if($this->_oldMediaType=="video" && $this->_oldMediaId){
			return UploadFile::model()->findByPk($this->_oldMediaId);
		}
	}
	
	public function getMediaLink(){
		if($this->mediaType=="link" && $this->mediaId){
			return MediaLink::model()->findByPk($this->mediaId);
		}
	}
	
	public function getOldMediaLink(){
		if($this->_oldMediaType=="link" && $this->_oldMediaId){
			return MediaLink::model()->findByPk($this->_oldMediaId);
		}
	}
	
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => Yii::t('app','标题'),
			'introduction'=>Yii::t('app','概述'),
			'courseId' => 'Course',
			'weight' => 'Weight',
			'addTime' => 'Add Time',
			'upTime' => 'Up Time',
			'mediaId' => Yii::t('app','媒体文件'),
			'mediaType' => Yii::t('app','类型'),
			'published'=>Yii::t('app','是否发布'),
			'mediaSource' => Yii::t('app','视频类型'),
			'mediaUri' => Yii::t('app','视频地址'),
			'mediaName' => 'Media Name',
			'isFree'=>Yii::t('app','是否免费'),
            'duration'  =>  '课时时长(分钟)',
			);
	}

	public function refreshAllNumbers($courseId){
		$lessons = Lesson::model()->findAllByAttributes(array('courseId'=>intval($courseId)),array('order'=>'weight asc'));
		$count = count($lessons);
		for($i=0;$i<$count;$i++){
			//	$lessons[$i]->update(array('number'=>$i+1));
			$lessons[$i]->number = $i+1;
			$lessons[$i]->save();
		}
	}

	public function behaviors(){
		return array(
			'noteable'=>array('class'=>'NoteableBehavior'),
			'commentable'=>array('class'=>'CommentableBehavior'),
			'voteable'=>array('class'=>'VoteableBehavior'),
			'attachment' => array('class' => 'AttachmentsBehavior',
		# Should be a DB field to store path/filename
				'attributes' => array('mediaUri'),
		# Default image to return if no image path is found in the DB
		//'fallback_image' => 'images/sample_image.gif',
				'path' => "uploads/:model/:id.:ext",
				),
			'uploadFile' => array('class' => 'UploadFileBehavior', 'items' =>array('mediaId'=>array('exts'=>array('mp4','flv'))))
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('courseId',$this->courseId);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('upTime',$this->upTime);
		$criteria->compare('mediaId',$this->mediaId,true);
		$criteria->compare('mediaSource',$this->mediaSource,true);
		$criteria->compare('mediaUri',$this->mediaUri,true);
		$criteria->compare('mediaName',$this->mediaName,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			));
	}
	public function getUrl(){
		if($this->mediaSource=="self") return Yii::app()->baseUrl.$this->file->path;
	}

	public function afterFind(){
		$this->_oldMediaType = $this->mediaType;
		$this->_oldMediaId = $this->mediaId;
	}

	protected function beforeSave(){
		//删除文件
		// if(!$this->isNewRecord){
		// 	if($this->mediaType!==$this->_oldMediaType
		// 		||($this->mediaType===$this->_oldMediaType && $this->mediaId!==$this->_oldMediaId)){
		// 		error_log(print_r($this,true));
		// 		if($this->_oldMediaType=="video"){
		// 			$this->file->delete();
		// 		}else if($this->_oldMediaType=="link"){
		// 			$this->mediaLink->delete();
		// 		}
		// 	}
		// }


		//创建quiz
		if($this->mediaType=="quiz" && $this->mediaId==0){
			$quiz = new Quiz;
			$quiz->save();
			$this->mediaId = $quiz->getPrimaryKey();
		}
		if($this->mediaType=="text" && $this->mediaId==0){
			$quiz = new Text;
			$quiz->save();
			$this->mediaId = $quiz->getPrimaryKey();
		}

		//设置课时数
		if(!$this->weight || !$this->number){
			$criteria = new CDbCriteria();
			$criteria->condition = "courseId=".intval($this->courseId);
			$criteria->select = "max(weight) as maxWeight,max(number) as maxNumber";
			$lesson= Lesson::model()->find($criteria);
			$chapter = Chapter::model()->find($criteria);
		}
		if(!$this->weight){
			if(!$lesson && !chapter){
				$this->weight = 1;
			}else if(!$lesson){
				$this->weight = $chapter->maxWeight+1;
			}else if(!$chapter){
				$this->weight = $lesson->maxWeight+1;
			}else{
				$this->weight = max(array($chapter->maxWeight,$lesson->maxWeight))+1;
			}
		}
		if(!$this->number){
			if($lesson){
				$this->number = $lesson->maxNumber+1;
			}else{
				$this->number = 1;
			}
		}

		return parent::beforeSave();
	}

	public function refreshAllChapterIds($courseId){
		$lessons = Lesson::model()->findAllByAttributes(array('courseId'=>intval($courseId)),array('order'=>'weight asc'));
		foreach($lessons as $lesson){
			$criteria = new CDbCriteria();
			$criteria->select = "id";
			$criteria->condition = "courseId=:courseId and weight<:weight";
			$criteria->params = array(':courseId'=>$courseId,':weight'=>$lesson->weight);
			$criteria->order = "weight desc";
			$criteria->limit = 1;
			$chapter = Chapter::model()->find($criteria);
			if($chapter)
				$lesson->chapterId=$chapter->id;
			else
				$lesson->chapterId=0;
			$lesson->save();
		}
	}

	public function deleteMedia(){
//		error_log("in lesson model $this->_oldMediaType");
		if($this->mediaType=="video" && $this->file){
			$this->file->delete();
		}else if($this->mediaType=="link" && $this->mediaLink){
			$this->mediaLink->delete();
		}
	}

	public function afterDelete(){
		$this->deleteMedia();
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Lesson the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
