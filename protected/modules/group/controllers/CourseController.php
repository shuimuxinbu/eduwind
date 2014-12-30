<?php

/**
 * CourseController
 */
class CourseController extends Controller
{
	/**
	 * @var string layout文件
	 */
	public $layout='//layouts/nonav_column1';


	/**
     * 过滤器规则
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
				'actions'=>array('myGroup','create','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
     * Create
     * @param integer $groupId
     * @param integer $courseId
	 */
	public function actionCreate($groupId,$courseId)
	{
		$model=new GroupCourse;

		$course = Course::model()->findByPk($courseId);
		$group = Group::model()->findByPk($groupId);
//		$member = $group->findMember(array('userId'=>Yii::app()->user->id));
		$member = GroupMember::model()->findByAttributes(array('groupId'=>$groupId,'userId'=>Yii::app()->user->id));
		if($course && $member && $member->inRoles(array('admin','superAdmin'))){
			$model->groupId = $groupId;
			$model->courseId = $courseId;
			$model->userId = Yii::app()->user->id;
			$model->addTime= time();
			echo $model->save();
			Yii::app()->user->setFlash('success',Yii::t('app','收藏成功！'));
		}
		echo false;
	}


	/**
     * Delete
	 * @param integer $id 
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($id);
			if($model->delete()){
				Yii::app()->user->setFlash('success',Yii::t('app','删除成功！'));
			}
		}
		else throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	/**
	 * Lists all models.
     * @param integer $courseId
	 */
	public function actionMyGroup($courseId)
	{
        $dataProvider = new CActiveDataProvider('Group',array(
            'criteria'=>array(
                'join'=>'inner join ew_group_member m on m.memberableEntityId=t.entityId',
                'condition'=>'m.userId=:userId and (find_in_set("admin",m.roles) or find_in_set("superAdmin",m.roles))',
                'params' => array(':userId'=>Yii::app()->user->id)
            ),
            'pagination'=>array('pageSize'=>10)
        ));
        $this->render('my_group_fancy',array('dataProvider'=>$dataProvider,'courseId'=>$courseId));
    }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=GroupCourse::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    

	/**
	 * Performs the AJAX validation.
	 * @param object $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='group-course-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
