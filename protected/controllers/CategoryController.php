<?php
class CategoryController extends Controller
{
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	public function accessRules()
	{
		return array(
		array('allow',  // allow all users to perform 'index' and 'view' actions
					'actions'=>array('children'),
					'users'=>array('*'),
		),
		array('allow',
				  'actions'=>array('sort','update','delete'),
				  'roles'=>array('admin'),
		),
		);
	}


	//配合联动的dropdownlist使用，返回次级分类
	public function actionChildren($parentId){
		$data=Category::model()->findAll('parentId=:parentId',
		array(':parentId'=>(int) $parentId));

		$data=CHtml::listData($data,'id','name');
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
			array('value'=>$value),CHtml::encode($name),true);
		}
	}
	

	public function actionSort(){
		//	var_dump($_POST);
		$items = $_POST['data'];
		$this->sort($items,0);
		echo true;

	}

	protected function sort($items,$parentId=0){
		foreach($items as $index=>$item){
			$model = $this->loadModel($item['id']);
			$model->saveAttributes(array('weight'=>$index+1,'parentId'=>$parentId));
			if(isset($item['children']) && is_array($item['children'])){
				$this->sort($item['children'],$item['id']);
			}
		}
	}
	
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}