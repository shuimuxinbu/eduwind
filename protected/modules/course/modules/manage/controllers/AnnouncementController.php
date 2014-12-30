<?php

class AnnouncementController extends CaController
{
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'expression'    =>  array($this, 'allowOnlyAdmin'),
            ),
            array(
                'deny',
            ),
        ); 
    }

    
    public function allowOnlyAdmin()
    {
        // 如果是站点管理员
        if(Yii::app()->user->checkAccess('admin')) return true;
        // 如果是课程管理员
        $course = Course::model()->findByPk(intval($_GET['courseId']));
        $member = $course->findMember(array('userId'=>Yii::app()->user->id));
        if($member && $member->inRoles(array('admin','superAdmin'))) return true;
        // 否则返回false
        return false;
    }


    public function filters()
    {
        return array(
            'accessControl'
        );
    }


    public function actionTest()
    {
        $user = Yii::app()->authManager;
        dd($user);
    }


    /**
     * 公告列表
     */
	public function actionIndex($courseId)
	{
        $course = $this->loadCourse($courseId);
        $dataProvider = new CActiveDataProvider('Announcement', array(
            'criteria'  =>  array(
                'condition' =>  "courseId={$courseId}",
                'order'     =>  'upTime DESC',
            ),
            'pagination'    =>  array(
                'pageSize'  =>  8 
            )
        ));
		$this->render('index', array('course'=>$course, 'dataProvider'=>$dataProvider));
	}


    /**
     * 新增公告
     */
    public function actionCreate($courseId)
    {
        $announcement = new Announcement();
        if(isset($_POST['Announcement'])):
            $_POST['Announcement']['addTime']   =   time();
            $_POST['Announcement']['upTime']    =   time();
            $_POST['Announcement']['courseId']  =   $courseId;
            $announcement->attributes = $_POST['Announcement'];
            if($announcement->save()):
				Yii::app()->user->setFlash('success', Yii::t('app','添加成功！'));
                $this->sendNotice($courseId, array('announcementId'=>$announcement->id), 'announcement_added');
                $this->redirect(array('index', 'courseId'=>$courseId));
            else:
				Yii::app()->user->setFlash('error', Yii::t('app','添加失败！'));
                $this->redirect(array('index', 'courseId'=>$courseId));
            endif;
        endif;
		$this->layout = "/layouts/nonav_column1";
        Yii::app()->clientScript->scriptMap['*.js'] = false;
        $this->renderPartial('create', array('model'=>$announcement), false, true);
    }


    /**
     * 发送Notice
     */
    private function sendNotice($courseId, $announcementId, $entityType='announcement_added')
    {
        $courseMember = new CourseMember();
        $members = $courseMember->findAllByAttributes(array('courseId'=>$courseId));
        
        foreach($members as $k=>$v)
        {
            $entity = new Entity();
            $eData['type']      = 'announcement';
            $entity->attributes =   $eData;
            $entity->save();
            
            $notice = new Notice();
            $nData['userId']    =   $v->userId;
            $nData['type']      =   $entityType;
            $nData['addTime']   =   time();
            $nData['data']      =   serialize(Announcement::model()->findByPk($announcementId)->id);
            $notice->attributes =   $nData;
            $notice->save();
        }
    }


    /**
     * 更新公告
     */
    public function actionUpdate($id, $courseId)
    {
        $announcement = $this->loadModel($id);
        if(isset($_POST['Announcement'])):
            $_POST['Announcement']['upTime'] = time();
            $announcement->attributes = $_POST['Announcement'];
            if($announcement->save()):
                Yii::app()->user->setFlash('success', Yii::t('app','更新公告成功'));
                $this->sendNotice($courseId, $announcement->id, 'announcement_updated');
                $this->redirect(array('index', 'courseId'=>$courseId));
            else:
                Yii::app()->user->setFlash('error', Yii::t('app','更新公告失败'));
                $this->redirect(array('index', 'courseId'=>$courseId));
            endif;
        endif;
        $this->renderPartial('update', array('model'=>$announcement), false, true);
    }

    
    /**
     * 删除公告
     */
    public function actionDelete($id, $courseId)
    {
        if($this->loadModel($id)->delete()):
            Yii::app()->user->setFlash('success', Yii::t('app','删除成功'));
            $this->redirect(array('index', 'courseId'=>$courseId));
        else:
            Yii::app()->user->setFlash('error', Yii::t('app','删除失败'));
            $this->redirect(array('index', 'courseId'=>$courseId));
        endif;
    }

    
    
    public function loadModel($id)
	{
		$model=Announcement::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}
