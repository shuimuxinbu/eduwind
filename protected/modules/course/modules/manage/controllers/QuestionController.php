<?php

class QuestionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/column2';
	public $course;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('create','update','order'),
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
	public function actionOrder(){
		if(isset($_POST['order'])){
			$idsString = $_POST['order'];
			$ids = explode(",",$idsString);
			for($i=0;$i<count($ids);$i++){
				$model = $this->loadModel($ids[$i]);
				$model->weight = $i+1;
				$result = $model->save();
				//$result = $model->updateByPk( $ids[$i],array("weight"=>$i) );
			}
		}
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
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
	public function actionCreate($quizId,$type="multiple-choice")
	{
		Yii::import('ext.multimodelform.MultiModelForm');

		$model=new Question(); //the Group model
		$model->quizId = $quizId;
		$model->type=$type;
		$quiz =  $this->loadQuiz($quizId);

		$choice = new Answer();
		$validatedChoices = array(); //ensure an empty array

		if(isset($_POST['Question'])){
			$model->attributes=$_POST['Question'];
			$model->save();

			//the value for the foreign key 'groupid'
			$masterValues = array ('questionId'=>$model->id);

			if( //Save the master model after saving valid members
			MultiModelForm::save($choice,$validatedChoices,$deleteMembers,$masterValues) &&
			$model->save()
			)
			$this->redirect(array('quiz/view','id'=>$quiz->id));
		}
		$this->render('create',array(
            'model'=>$model,
		//submit the member and validatedItems to the widget in the edit form
            'choice'=>$choice,
            'validatedChoices' => $validatedChoices,
        	'lesson'=>$quiz->lesson,
			'quiz'=>$quiz,
			'course'=>$quiz->lesson->course,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		Yii::import('ext.multimodelform.MultiModelForm');

		$model=$this->loadModel($id); //the Group model
		$quiz =  $model->quiz;

		$choice = new Answer();
		$validatedChoices = array(); //ensure an empty array

		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];

			//the value for the foreign key 'groupid'
			$masterValues = array ('questionId'=>$model->id);

			if( //Save the master model after saving valid members
			MultiModelForm::save($choice,$validatedChoices,$deleteMembers,$masterValues) &&
			$model->save()
			)
			$this->redirect(array('quiz/view','id'=>$quiz->id));
		}

		$this->render('update',array(
            'model'=>$model,
		//submit the member and validatedItems to the widget in the edit form
            'choice'=>$choice,
            'validatedChoices' => $validatedChoices,
        	'lesson'=>$quiz->lesson,
			'quiz'=>$quiz,
			'course'=>$quiz->lesson->course,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Question');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Question::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadQuiz($id)
	{
		$model=Quiz::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='question-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
