<?php

class AreaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
		array('allow',  // deny all users
				'users'=>array('*'),
		),
		);
	}
	
	public function actionListCity(){
//		$data=::model()->findAll('referid=:referid',
		if(isset($_POST['provinceId'])) $provinceId = $_POST['provinceId'];
		$cities = Province::model()->findByPk($provinceId)->cities;

//		$data=CHtml::listData($data,'id','name');
		foreach($cities as $city)
		{
			echo CHtml::tag('option',
			array('value'=>$city->id),CHtml::encode($city->name),true);
		}
	}
}
