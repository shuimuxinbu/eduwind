<?php

/**
 * This is the model class for table "ew_upgrade_info".
 *
 * The followings are the available columns in table 'ew_upgrade_info':
 * @property integer $id
 * @property integer $versionId
 * @property string $version
 * @property string $name
 * @property string $description
 * @property integer $addTime
 * @property string $status
 */
class UpgradeInfo extends CActiveRecord
{

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ew_upgrade_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('versionId, version, name, description, addTime', 'required'),
			array('versionId, addTime', 'numerical', 'integerOnly'=>true),
			array('version, status', 'length', 'max'=>32),
			array('name', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, versionId, version, name, description, addTime, status', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'versionId' => 'VersionId',
			'version' => Yii::t('app','版本号'),
			'name' => Yii::t('app','更新包名称'),
			'description' => Yii::t('app','更新包描述'),
			'addTime' => Yii::t('app','添加时间'),
			'status' => Yii::t('app','状态'),
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
		$criteria->compare('versionId',$this->versionId);
		$criteria->compare('version',$this->version,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UpgradeInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	/**
	 * 得到客户端最新的版本id
	 * Enter description here ...
	 */
	private static function getLatestVersionId() {
		$latestVersionId = 0;
		
		$criteria = new CDbCriteria;
		$criteria->select = 'versionId';
		$criteria->order = 'versionId DESC';
		$criteria->limit = 1;
		$model = self::model()->find($criteria);
		
		if ($model) {
			$latestVersionId = $model->versionId;
		}
		
		return $latestVersionId;
	}
	
	public static function compareVersion($version1,$version2){
		$parts1 =  explode(".", $version1);
		$parts2 =  explode(".", $version2);
//		error_log(print_r($parts2,true));
//		error_log($parts1[2]);
		
		$result = 0;
		for($index=0;$index<count($parts1);$index++){
			$result = $parts1[$index]-$parts2[$index];
			if($result!==0) break;
			
		}
		//error_log('end'.$result);
		return $result;
	}
	

	
}
