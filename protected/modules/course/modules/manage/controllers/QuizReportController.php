<?php

class QuizReportController extends Controller
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
				'actions'=>array('create','update','member','questions'),
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


	public function actionIndex($courseId){
		//		$lessons = Lesson::model()->findAllByAttributes(array('courseId'=>$courseId,'mediaType'=>'quiz'));
		//		$lessonDataProvider = new CActiveDataProvider('Lesson',array('criteria'=>array('condition'=>"courseId=:courseId and mediaType=:mediaType",
		//																						'params'=>array(':courseId'=>$courseId,':mediaType'=>"quiz"))));
		$this->course = $this->loadCourse($courseId);
		$criteria = new CDbCriteria();
		$criteria->join ="left join ew_lesson l on l.mediaId=t.id and l.courseId=".intval($courseId);
		$criteria->condition = "l.mediaType='quiz'";
		$criteria->order = "l.number asc";
		//		$criteria->with = "lesson";
		//		$quiz = new CActiveDataProvider('Quiz',$criteria);
		$quizs = Quiz::model()->findAll($criteria);
		$quizDataProvider = new CArrayDataProvider($quizs);
		$this->render('index',array('quizDataProvider'=>$quizDataProvider,));
	}

	public function actionMember($courseId){
		$this->course = $this->loadCourse($courseId);
		//$memberDataProvider = new CActiveDataProvider('CourseMember',array('criteria'=>array('condition'=>"courseId=".$this->course->id)));
//		$members = CourseMember::model()->findAll(array('condition'=>"courseId=".$this->course->id));
//		$courseQuizSummarys = array();
//		foreach($members as $member){
//			$courseQuizSummarys[] = new CourseQuizSummary($member->userId, $courseId);
//		}
//		$courseQuizSummaryDataProvider = new CArrayDataProvider($courseQuizSummarys,array('keyField'=>false));
		$courseQuizReportDataProvider = new CActiveDataProvider('CourseQuizReport',array('criteria'=>array('condition'=>'courseId=:courseId','params'=>array(':courseId'=>$courseId))));
		$this->render('member',array('courseQuizReportDataProvider'=>$courseQuizReportDataProvider));
	}

	public function actionView($quizId){
		$quizReportDataProvider = new CActiveDataProvider('QuizReport',array('criteria'=>array('condition'=>'quizId='.intval($quizId))));
		$quiz = Quiz::model()->findByPk($quizId);
		$this->course = $this->loadCourse($quiz->lesson->courseId);
		$this->render('view',array('quizReportDataProvider'=>$quizReportDataProvider,'quiz'=>$quiz));
	}

	public function getReportColumn($data,$row){
		$result = "";
		//	var_dump($data->responses);
		foreach($data->responses as $response){
			if($response){
				//$result .= $response->question->weight."&nbsp;".$response->questionId.$response->question->stem."<br/>";
				if($response->status==QuestionResponse::STATUS_CORRECT) $result .="<span class='text-success'>".($response->question->weight+1)."</span>&nbsp;&nbsp;&nbsp;";
				elseif($response->status==QuestionResponse::STATUS_PARTIAL_CORRECT) $result .="<span class='text-warning'>".($response->question->weight+1)."</span>&nbsp;&nbsp;&nbsp;";
				elseif($response->status==QuestionResponse::STATUS_WRONG) $result .="<span class='text-error'>".($response->question->weight+1)."</span>&nbsp;&nbsp;&nbsp;";
			}
		}
		return $result;
	}

	public function getQuestionColumn($data,$row,$dataColumn){
		$method = "";
		switch($dataColumn->header){
			case 'A':
				$method = 'aAnswer';
				break;
			case 'B':
				$method = 'bAnswer';
				break;
			case 'C':
				$method = 'cAnswer';
				break;
			case 'D':
				$method = 'dAnswer';
				break;
			case 'E':
				$method = 'eAnswer';
				break;
			case 'F':
				$method = 'fAnswer';
				break;
		}
		if($method){
			$answer = $data->$method;
			if($answer){
				$name = $dataColumn->name;
				$count = $data->$name;
				return $answer->isCorrect?"<span class='text-success'>$count</span>":"<span class='text-error'>$count</span>";
			}
		}
	}
	public function actionQuestions($quizId){
		$quiz = $this->loadModel($quizId);
/*		$questionDataProvider = new CActiveDataProvider('Question',
		array('criteria'=>array('condition'=>'quizId=:quizId','order'=>'t.weight asc','params'=>array(':quizId'=>$quiz->id)),
													'pagination'=>array('pageSize'=>30),
		));
		$questions = $questionDataProvider->getData();
		$questionAnalyses = array();
		foreach($questions as $question){
			$questionAnalyses[] = new QuestionAnalyse($question->id);
		}
		$questionAnalyseDataProvider = new CArrayDataProvider($questionAnalyses,array('keyField'=>'questionId'));
		*/
		$criteria = new CDbCriteria();
		$criteria->join = "left join ew_question q on q.id=t.questionId";
		$criteria->condition = "q.quizId=:quizId";
		$criteria->params = array(':quizId'=>$quizId);
		$questionReportDataProvider = new CActiveDataProvider('QuestionReport',array('criteria'=>$criteria));
		$this->course = $quiz->lesson->course;
		//$questionAnalyse = new QuestionAnalyse($id);
		$this->render('questions',array('questionReportDataProvider'=>$questionReportDataProvider,'quiz'=>$quiz));
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

	public function loadCourse($id)
	{
		$model=Course::model()->findByPk($id);
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
}
