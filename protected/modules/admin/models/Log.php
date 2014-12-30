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
class Log extends EntityActiveRecord
{
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
        return '{{log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, level,category,logtime,message,userId,ip', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'level' => Yii::t('app','等级'),
            'category' => Yii::t('app','类别'),
            'logtime' => Yii::t('app','时间'),
            'message' => Yii::t('app','信息'),
            'userId' => Yii::t('app','用户'),
        	'ip'=>'用户IP',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize=100,$order="logtime desc")
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('level',$this->level);
        $criteria->compare('category',$this->category,true);
        $criteria->compare('logtime',$this->logtime);
        $criteria->compare('message',$this->message,true);
        $criteria->compare('userId',$this->userId);
        $criteria->compare('ip',$this->ip);
        $criteria->order = $order;
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

}
