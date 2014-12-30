<?php

/**
 * This is the model class for table "{{teacher}}".
 *
 * The followings are the available columns in table '{{teacher}}':
 * @property integer $id
 * @property integer $userId
 * @property integer $categoryId
 * @property string $name
 */
class People extends CActiveRecord
{
    /**
     * 人员分类
     */
    public $categorys;
    public $userId = 0;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cms_people}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, categoryId', 'required'),
			array('id, userId, categoryId', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('description, face', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
		);
	}

    /**
     * Behaviors
     */
    public function behaviors()
    {
        return array(
			'attachments'=>array('class'=>'AttachmentsBehavior','items'=>array('face'=>array('exts'=>array('png','jpg','jpeg')))),
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
            'user'  =>  array(self::HAS_ONE, 'UserInfo', array('id'=>'userId')),
            //'user'  =>  array(self::BELONGS_TO, 'UserInfo', 'userId'),
            'category'  =>  array(self::BELONGS_TO, 'Category', 'categoryId')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' => Yii::t('app','用户ID'),
            'face' => Yii::t('app','头像'),
			'categoryId' => Yii::t('app','人员分类'),
			'name' => Yii::t('app','人员姓名'),
            'userName' => Yii::t('app','用户名'),
            'description' => Yii::t('app','人员简介'),
		);
	}


    /**
     * 检查用户是否存在
     */
    public function checkUser()
    {
        parent::beforeSave();
        $user = UserInfo::model()->find("name='{$_POST['People']['userName']}'");
        if (!isset($user)) {
            Yii::app()->user->setFlash('error',Yii::t('app', '用户不存在');
            Yii::app()->controller->redirect(array('create', 'userName'=>$_POST['People']['userName']));
        } else {
            $this->userId = $user->id;
            return true;
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

		$criteria->compare('t.name',$this->name,true);
        $criteria->with =   array('user', 'category');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return People the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
