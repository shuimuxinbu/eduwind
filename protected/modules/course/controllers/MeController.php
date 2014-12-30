<?php

class MeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $activeMenu = "me";

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
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','learning','manage','noteList','note','collect'),
				'users'=>array('@'),
		),
		array('allow',
			  'actions'=>array('create'),
			  'roles'=>array('teacher')),
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
	 * 在学的课程
	 */
	public function actionIndex(){
		$this->redirect(array('learning'));
	}

	public function actionLearning(){
		
		$courseDataProvider = new CActiveDataProvider('Course',array(
														'criteria'=>array('join'=>'left join ew_course_member m on t.id=m.courseId',
																		  'condition'=>'find_in_set("student",m.roles) and m.userId='.Yii::app()->user->id,
																			'distinct'=>true,
																		  'order'=>'m.startTime desc'),
														'pagination'=>array('pageSize'=>12))
		);
		$user = UserInfo::model()->findByPk(Yii::app()->user->id);
		$this->render("index",array('user'=>$user,
											'courseDataProvider'=>$courseDataProvider));
	}

	public function actionManage(){
		
		$courseDataProvider = new CActiveDataProvider('Course',array(
														'criteria'=>array('join'=>'inner join ew_course_member m on t.id=m.courseId',
																			'distinct'=>true,
																		'condition'=>'find_in_set("admin",roles) or find_in_set("superAdmin",roles) and m.userId='.Yii::app()->user->id,
																		  'order'=>'m.startTime desc'),
																		'pagination'=>array('pageSize'=>12))
		);
		$user = UserInfo::model()->findByPk(Yii::app()->user->id);
		$this->render("index",array('user'=>$user,
											'courseDataProvider'=>$courseDataProvider));
		}
	public function actionCollect(){
		
		$courseDataProvider =  Course::model()-> getCollectionDataProvider(Yii::app()->user->id,12);
		$user = UserInfo::model()->findByPk(Yii::app()->user->id);
		$this->render("index",array('user'=>$user,
											'courseDataProvider'=>$courseDataProvider));
		}
	/**
	 * 以课程为单位列出笔记本
	 */
	public function actionNoteList(){
		$userId = Yii::app()->user->id;
		//$sql = "select n.*,count(n.*) as siblingCount from note n left join lesson l on n.noteableEntityId=l.entityId group by l.courseId order by n.addTime where n.userId=$userId";
		$sql = "select n.*,count(*) as siblingCount,l.courseId as courseId from ew_note n left join ew_lesson l on n.noteableEntityId=l.entityId where n.userId=".Yii::app()->user->id." group by l.courseId order by n.addTime";
		//$sql = "select n.*,count(*) as siblingCount from note lpn inner join dxd_lesson l on lpn.lessonid=l.lessonid where lpn.userId=$userId group by l.courseId order by lpn.addTime desc";
		//$lessonNotes = LessonNote::model()->with('lesson.course')->findAllBySql($sql);
		$notes = Note::model()->findAllBySql($sql);
		$dataProvider =new  CArrayDataProvider($notes);
		//		$dataProvider = new CSqlDataProvider($sql,array('keyField'=>'noteid'));
		//$dataProvider=new CActiveDataProvider('LessonNote');
		$this->render('my_notes_index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	/**
	 * 列出某个课程下的所有笔记
	 * Enter description here ...
	 * @param unknown_type $courseId
	 */
	public function actionNote($courseId){
				$courseId = intval($courseId);
		$course = Course::model()->findByPk($courseId);
		$sql = "select n.*,l.id as lessonId from ew_course c inner join ew_lesson l on c.id=l.courseId inner join ew_note n on n.noteableEntityId=l.entityId where c.id=$courseId";
		$notes = Note::model()->findAllBySql($sql);
		$dataProvider = new CArrayDataProvider($notes);
		$this->render('my_notes',array(
			'dataProvider'=>$dataProvider,
			'course'=>$course,
		//			'model'=>$this->loadModel($id),
		));
	}

}
