<?php

/**
 * This is the model class for table "{{article}}".
 *
 * The followings are the available columns in table '{{article}}':
 * @property integer $id
 * @property integer $entityId
 * @property integer $categoryId
 * @property string $title
 * @property string $face
 * @property string $content
 * @property string $description
 * @property integer $addTime
 * @property integer $upTime
 * @property string $keyWord
 * @property integer $commentNum
 * @property integer $viewNum
 * @property integer $isTop
 */
class Article extends EntityActiveRecord
{
	public $defaultFace = "http://placehold.it/200x200";

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{article}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('title, uid, content', 'required'),
			array('entityId, uid, categoryId, addTime, upTime, commentNum, viewNum, isTop', 'numerical', 'integerOnly'=>true),
			array('title, face, keyWord', 'length', 'max'=>255),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, keyWord', 'safe', 'on'=>'search'),
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

    public function behaviors(){
		return array(
			'commentable'=>array('class'=>'CommentableBehavior'),
			'attachments'=>array('class'=>'AttachmentsBehavior','items'=>array('face'=>array('exts'=>array('png','jpg','jpeg')))),
			'categoryable'=>array('class'=>'CategoryableBehavior'),

		);
    }


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'uid'=>Yii::t('app','用户ID'),
			'entityId' => 'EntityId',
			'categoryId' => Yii::t('app','文章分类'),
			'title' => Yii::t('app','标题'),
			'face' => Yii::t('app','封面'),
			'content' => Yii::t('app','内容'),
			'description' => Yii::t('app','简介'),
			'addTime' => Yii::t('app','添加时间'),
			'upTime' => Yii::t('app','更新时间'),
			'keyWord' => Yii::t('app','关键字'),
			'commentNum' => Yii::t('app','评论数'),
			'viewNum' => Yii::t('app','阅读数'),
			'isTop' => Yii::t('app','是否置顶'),
            'status'=>Yii::t('app','状态'),
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
	public function search($pageSize=20)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keyWord',$this->keyWord,true);

		return new CActiveDataProvider($this, array(
			'criteria'  =>  $criteria,
            'pagination'  =>  array(
                'pageSize'  =>  $pageSize,
            )
		));
	}
	public function getPageUrl(){
		return Yii::app()->createUrl('/cms/article/index',array('id'=>$this->id));
	}

    /**
     *
     */
    public function getXFace()
    {
        if (isset($this->face)) {
            return Yii::app()->baseUrl . "/" . $this->face;
        } else {
            return  Yii::app()->baseUrl ."/" . $this->defaultFace;
        }
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Article the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
