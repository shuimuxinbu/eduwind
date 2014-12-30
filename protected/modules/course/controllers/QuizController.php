<?php

class QuizController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
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
				'actions'=>array('index','view','counter'),
				'users'=>array('*'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','take'),
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
	public function actionView($id)
	{
		$quiz = $this->loadModel($id);
		$lesson = $quiz->lesson;
		$response = new QuestionResponse();
		$questionDataProvider = new CActiveDataProvider('Question',array('criteria'=>array('condition'=>"quizId=$lesson->mediaId",'order'=>'weight asc')));
		$validatedAnswers = array(); //ensure an empty array

		$this->render("view",array('lesson'=>$lesson,
										'course'=>$lesson->course,
										'questionDataProvider'=>$questionDataProvider,
										'quiz'=>$quiz,
										'validatedAnswers'=>$validatedAnswers,
										'response'=>$response,
		));
	}

	public function actionTake($id,$showAnalyse=1){
	//	$questions = Question::model()->findAll(array('condition'=>'quizId=:quizId','params'=>array(':quizId'=>$id),'with'=>array('answer','choices')));
		$questionDataProvider = new CActiveDataProvider('Question',array('criteria'=>array('condition'=>'quizId=:quizId',
																			'params'=>array(':quizId'=>$id),
																			'with'=>array('choices'),
																			'order'=>'t.weight asc'),
																		'pagination'=>array('pageSize'=>30)));
		$questions = $questionDataProvider->getData();
		$quiz = $this->loadModel($id);
		$lesson = $quiz->lesson;
		if(isset($_POST['QuestionResponse']))
		{
			$saved=true;
			//		foreach($items as $i=>$item)
			foreach($questions as $i=>$question)
			{
				$response = $question->userResponse(Yii::app()->user->id);
				$response or $response =  new QuestionResponse();
				if(isset($_POST['QuestionResponse'][$i])){
					$response->attributes=$_POST['QuestionResponse'][$i];
					$response->userId = Yii::app()->user->id;			
					$saved = $response->save() && $saved;
				}
			}
			if($saved) {
				$learn = LessonLearn::model()->findByAttributes(array('userId'=>Yii::app()->user->id,'lessonId'=>$lesson->id));
				$learn->finish();
			}
		}
		// displays the view to collect tabular input
		$report = $quiz->userReport(Yii::app()->user->id);
		$showAnalyse = $showAnalyse && !empty($report);
		$this->render('view',array('questionDataProvider'=>$questionDataProvider,'lesson'=>$lesson,'report'=>$report,'showAnalyse'=>$showAnalyse));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadLesson($id)
	{
		$model=Lesson::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='quiz-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * 计数器
	 * @param unknown_type $course
	 */
	public function actionCounter($id){
		$lesson = $this->loadLesson($id);
		$lesson->viewNum+=1;
		$lesson->save();
		$course = $lesson->course;
		$course->viewNum+=1;
		$course->save();
	}
}
