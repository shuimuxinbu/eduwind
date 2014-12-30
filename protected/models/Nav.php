<?php

/**
 * This is the model class for table "ew_nav".
 *
 * The followings are the available columns in table 'ew_nav':
 * @property integer $id
 * @property string $title
 * @property string $activeRule
 * @property integer $weight
 * @property string $url
 */
class Nav extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{nav}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,url','required'),
			array('weight', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>32),
			array('activeRule, url,displayRule', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, activeRule, weight, url', 'safe', 'on'=>'search'),
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
			'title' => Yii::t('app','标题'),
			'activeRule' => 'Active Rule',
			'weight' => 'Weight',
			'url' => Yii::t('app','链接地址'),
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
		$criteria->compare('activeRule',$this->activeRule,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('url',$this->url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			));
	}

	public static function getTopItems(){
		$navs = Nav::model()->findAll(array('order'=>'weight asc'));
		$items = array();
		foreach($navs as $nav){
			$display = @eval($nav->displayRule);
			if($display){
				$item = array();
				if(DxdUtil::startWith($nav->url, 'http://') || DxdUtil::startWith($nav->url, 'https://'))
				{
					$item['url']=$nav->url;
				}else{
					$item['url']=Yii::app()->createUrl($nav->url);
				}
				if($nav->activeRule)
					$item['active'] =eval($nav->activeRule);
				$item['label'] = $nav->title;
				$items[] = $item;
			}
		}
		return $items;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Nav the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
