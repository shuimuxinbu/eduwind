<?php

/**
 * 后台小组管理Controller
 */
class CategoryController extends Controller
{
	/**
	 * @var string layout文件
	 */
	public $layout='//layouts/admin/nonav_column1';


	/**
     * 过滤器方法
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}


	/**
     * 当前控制器的访问规则
     *
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('create','update','course','wish','delete','index'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
     * View
	 * @param integer $id
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Category;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			if($model->save())
				$this->redirect(array('index','type'=>$model->type));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate($id)
	{
        $model = $this->loadModel($id);
		if(isset($_POST['Category']))
		{
            $model->attributes = $_POST['Category'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '操作成功');
                $this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('error', '操作失败');
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        if ($this->loadModel($id)->delete()) {
            Yii::app()->user->setFlash('success', '操作成功');
            $this->redirect(array('index'));
        } else {
            Yii::app()->user->setFlash('error', '操作失败');
            $this->redirect(array('index'));
        }

	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new Category();
		$this->render("index",array('model'=>$model,'type'=>'group'));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param object $model CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
