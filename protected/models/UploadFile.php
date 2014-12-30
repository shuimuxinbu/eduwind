<?php

/**
 * This is the model class for table "ew_upload_file".
 *
 * The followings are the available columns in table 'ew_upload_file':
 * @property integer $id
 * @property integer $userId
 * @property integer $addTime
 * @property string $status
 * @property string $path
 * @property string $mime
 * @property string $type
 * @property string $name
 * @property integer $size
 */
class UploadFile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{upload_file}}';
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
			array('userId, addTime, size', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>32),
			array('path, name', 'length', 'max'=>255),
			array('mime, type', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userId, addTime, status, path, mime, type, name, size', 'safe', 'on'=>'search'),
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
			'userId' => 'User',
			'addTime' => 'Add Time',
			'status' => 'Status',
			'path' => 'Path',
			'mime' => 'Mime',
			'type' => 'Type',
			'name' => 'Name',
			'size' => 'Size',
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('addTime',$this->addTime);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('mime',$this->mime,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('size',$this->size);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UploadFile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function afterDelete(){
		$fullPath = Yii::app()->basePath."/../".$this->path;
	     if(file_exists($fullPath) && $this->storage=="local") {
	     	return unlink($fullPath);
	     }elseif ($this->storage=="cloud"){
	     	error_log("in upload file model");
	     	//删除文件
	     	$cloudService = CloudService::getInstance();
	     	$cloudService->deleteFile($this->path);
	     	//如果切片了，删除切片
	     	if ($this->convertStatus == "success") {
	     		$cloudService->deleteSlices($this->convertKey);
	     	}
	     	
	     }
	}
}
