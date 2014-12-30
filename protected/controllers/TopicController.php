<?php

class TopicController extends Controller
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
		array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'togglefollow'),
				'users'=>array('@'),
		),
		array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
		),
		array('deny',  // deny all users
				'users'=>array('*'),
		),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($name,$type='course')
	{
		/*		$dataProvider=new CActiveDataProvider('Course');
		 $criteria=new CDbCriteria;
		 $courses = Course::model()->taggedWith($name)->findAll();
		 //if ($courses == array()) throw new CHttpException(404,'The requested page does not exist.');
		 foreach ($courses as $course) {
			$courseIdarray[] = $course->courseId;
			}
			$courseIds = implode(',',$courseIdarray);
			$criteria->condition = 'courseId in ('.$courseIds.')';
			$criteria->order = 'courseId desc';
			$dataProvider->setCriteria($criteria);
			$pages=new CPagination(count($courseIdarray));
			$pages->pageSize=12;
			$dataProvider->setPagination($pages);
			*/
		$topic = $this->loadModel($name);
		//if($type=='course'){
		$courseDataProvider = new CArrayDataProvider($topic->courses,array('keyField'=>'courseId'));
		//}
		$questionDataProvider = new CArrayDataProvider($topic->questions,array('keyField'=>'id'));
		$this->render('view',array(
			'topic'=>$topic,
			'type'=>$type,
			'courseDataProvider'=>$courseDataProvider,
			'questionDataProvider'=>$questionDataProvider,
		
		));

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	/*
	 public function actionCreate()
	 {
		$model=new Topic;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Topic']))
		{
		$model->attributes=$_POST['Topic'];
		if($model->save())
		$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
		'model'=>$model,
		));
		}
		*/

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*
	 public function actionUpdate($id)
	 {
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Topic']))
		{
		$model->attributes=$_POST['Topic'];
		if($model->save())
		$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
		'model'=>$model,
		));
		}
		*/

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	/*
	 public function actionDelete($id)
	 {
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		*/
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Topic');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Topic('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Topic']))
		$model->attributes=$_GET['Topic'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Topic the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($name)
	{
		//$model=Topic::model()->findByPk($id);
		$model = Topic::model()->findByAttributes(array('name'=>$name));
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Topic $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='topic-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * 关注或取消关注
	 * Enter description here ...
	 * @param unknown_type $followed_topicid
	 */
	public function actionToggleFollow($topicid){
		$follow = TopicFollow::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'topicid'=>$topicid));
		if(!$follow){
			$follow = new TopicFollow;
			$follow->userId = Yii::app()->user->id;
			$follow->topicid = $topicid;
			$follow->addTime = time();
			if($follow->save()){
				echo true;
				Yii::app()->end();
			}
		}else{
			$follow->delete();
			echo false;
		}
	}
}
