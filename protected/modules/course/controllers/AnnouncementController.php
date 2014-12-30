<?php

class AnnouncementController extends Controller
{
	public function filters()
	{
		return array(
            'accessControl',
		);
	}


    public function accessRules()
    {
        return array(
            array(
                'allow',
                'users' =>  array('*'),
            ),
        );
    }


    /**
     * Index
     */
	public function actionIndex()
	{
		$this->render('index');
	}


    /**
     * 公告详细
     */
    public function actionDetail($id)
    {
        $announcement = $this->loadModel($id);
        Yii::app()->clientScript->scriptMap['*.js'] = false;
        $this->renderPartial('detail', array('announcement'=>$announcement), false, true);
    }


    /**
     * 所有公告列表
     */
    public function actionList($courseId)
    {
        $announcementDataProvider = new CActiveDataProvider('Announcement', array(
            'criteria'  =>  array(
                'condition' =>  "courseId={$courseId}",
                'order'     =>  'upTime DESC',
            ),
            'pagination'   =>  array(
                'pageSize'  =>  3,
            ),
        ));
        Yii::app()->clientScript->scriptMap['*.js'] = false;
        $this->renderPartial('list', array('announcementDataProvider'=>$announcementDataProvider), false, true);
    }


    public function loadModel($id)
	{
		$model=Announcement::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}



}
