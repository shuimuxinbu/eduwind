<?php

class ViewCountController extends Controller
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
		//'rights',
		);
	}

	public function accessRules()
	{
		return array(
		array('allow',  // allow all users
			'users'=>array('*'),
		),
		);
	}


	public function actionCourse($courseId){
		$course = Course::model()->findByPk($courseId);
		$course->viewNum = $course->viewNum + 1;
		if($course->save()){
			$courseView = new CourseView;
			$courseView->userId = Yii::app()->user->isGuest ? 0 : Yii::app()->user->id;
			$courseView->ip = Yii::app()->request->getUserHostAddress();
			$courseView->courseId = $courseId;
			$courseView->save();
		}
	}

	public function actionPost($groupid,$postid){
		$group = Group::model()->findByPk($groupid);
		$group->viewNum = $group->viewNum + 1;
		$post = Post::model()->findByPk($postid);
		$post->viewNum = $post->viewNum + 1;
		if($group->save() && $post->save()){
			$postView = new PostView;
			$postView->userId = Yii::app()->user->isGuest ? 0 : Yii::app()->user->id;
			$postView->ip = Yii::app()->request->getUserHostAddress();
			$postView->postid = $postid;
			$postView->save();
		}
	}

	public function actionLesson($courseId,$lessonid){
		$course = Course::model()->findByPk($courseId);
		$course->viewNum = $course->viewNum + 1;
		$lesson = Lesson::model()->findByPk($lessonid);
		$lesson->viewNum = $lesson->viewNum + 1;
		if($course->save() && $lesson->save()){
			$lessonView = new LessonView;
			$lessonView->userId = Yii::app()->user->isGuest ? 0 : Yii::app()->user->id;
			$lessonView->ip = Yii::app()->request->getUserHostAddress();
			$lessonView->lessonid = $lessonid;
			$lessonView->save();
		}
	}

	public function actionTopic($topicid){
		$topicView = new TopicView;
		$topicView->userId = Yii::app()->user->isGuest ? 0 : Yii::app()->user->id;
		$topicView->ip = Yii::app()->request->getUserHostAddress();
		$topicView->topicid = $topicid;
		$topicView->save();
	}

	public function actionCourseRate($courseId){
		$course = Course::model()->findByPk($courseId);
		$course->viewNum = $course->viewNum + 1;
		if($course->save()){
			$courseRateView = new CourseRateView;
			$courseRateView->userId = Yii::app()->user->isGuest ? 0 : Yii::app()->user->id;
			$courseRateView->ip = Yii::app()->request->getUserHostAddress();
			$courseRateView->courseId = $courseId;
			$courseRateView->save();
		}
	}
	
	public function actionQuestion($questionid){
		$question = Question::model()->findByPk($questionid);
		$question->viewNum = $question->viewNum + 1;
		if($question->save()){
			$questionView = new QuestionView;
			$questionView->userId = Yii::app()->user->isGuest ? 0 : Yii::app()->user->id;
			$questionView->ip = Yii::app()->request->getUserHostAddress();
			$questionView->questionid = $questionid;
			$questionView->save();
		}
	}

}
