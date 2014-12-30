<?php

class PeopleController extends Controller
{
	/**
     * @var string 当前控制器视图布局文件
	 */
	public $layout='//layouts/admin/nonav_column2';

    /**
     * @var string 人员头像存储路径
     */
    private $facePath = 'uploads/Course/People/face/thumbs';

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
			array('allow',
				'roles'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

    /**
     * 关联外部的动作
     * @return array 外部动作
     */
    public function actions()
    {
        return array(
            'uploadFace'=>array(
                'class'=>'application.components.actions.jcrop.UploadImageAction',
                'attribute'=>'face',
            ),
        );
    }

	/**
     * 把一个用户任命为人员页面和处理方法
     * @param integer $uid 用户ID
	 */
	public function actionCreate()
	{
		$model  =   new People;
        $model->categorys = Category::model()->findAll(array(
            'condition' =>  'type="teacher"',
            'order'     =>  'weight ASC',
        ));

		if(isset($_POST['People']))
		{
            $model->checkUser();
            $model->attributes=$_POST['People'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '操作成功');
                $this->redirect(array('uploadFace', 'id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', '操作失败');
            }
        }

		$this->render('create', array('model' => $model,));
	}

	/**
     * 更新人员信息页面和处理方法
	 * @param integer $id 人员ID
	 */
	public function actionUpdate($id)
	{
		$model  =   $this->loadModel($id)->with(array('user'));
        $model->categorys = Category::model()->findAll('type="teacher"');

		if(isset($_POST['People']))
		{
            $user = UserInfo::model()->find("name='{$_POST['People']['userName']}'");
            // 用户是否存在
            if (!isset($user)) {
                Yii::app()->user->setFlash('error', '用户不存在');
            } else {
                $model->userId = $user->id;
                $model->attributes=$_POST['People'];
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', '操作成功');
                    $this->redirect(array('index'));
                } else {
                    Yii::app()->user->setFlash('error', '操作失败');
                }
            }
        }

		$this->render('update',array(
			'model' =>  $model,
		));
	}

	/**
     * 删除一个人员处理方法
	 * @param integer $id 人员ID
	 */
	public function actionDelete($id)
	{
	    if ($this->loadModel($id)->delete()) {
            Yii::app()->user->setFlash('success', '操作成功');
            $this->redirect(array('index'));
        } else {
            Yii::app()->user->setFlash('error', '操作失败');
        }
	}

	/**
	 * 控制器默认页面,列出所有人员和添加人员
	 */
	public function actionIndex()
	{
        $model = new People('search');
        if (isset($_GET['People'])) {
            $model->attributes = $_GET['People'];
        }
		$this->render(
            'index',
            array(
                'model'=>$model,
            )
        );
	}

    /**
     * 创建人员分类和处理方法
     */
    public function actionCategory()
    {
        $model      =   new Category();
        $type       =   'teacher';
        if (isset($_POST['Category'])) {
            $model->type = $type;
            $model->attributes = $_POST['Category'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '操作成功');
                $this->redirect(array('category'));
            }
        }
        $this->render(
            'category',
            array(
                'model'=>$model,
                'type'=>$type,
            )
        );
    }

    /**
     * 更新人员分类页面和处理
     * @param integer $categoryId 分类ID
     */
    public function actionUpdateCategory($categoryId)
    {
        $model = Category::model()->findByPk($categoryId);
        // 处理表单提交
        if (isset($_POST['Category'])) {
            $model->attributes = $_POST['Category'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '操作成功');
                $this->redirect(array('category'));
            } else {
                Yii::app()->user->setFlash('error', '操作成功');
            }
        }
        $this->render(
            'updateCategory',
            array(
                'model' =>  $model,
            )
        );
    }

    /**
     * 删除人员分类处理
     * @param integer $categoryId 分类ID
     */
    public function actionDeleteCategory($categoryId)
    {
        if (Category::model()->findByPk($categoryId)->delete()) {
            Yii::app()->user->setFlash('success', '操作成功');
            $this->redirect(array('category'));
        } else {
            Yii::app()->user->setFlash('error', '操作失败');
            $this->redirect(array('category'));
        }
    }

    /**
     * 裁剪封面图页面和处理方法
     * @param integer $id 文章ID
     */
    public function actionCropFace($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['imageId_x'])) {
            Yii::import('ext.jcrop.EJCropper');
            $jcropper = new EJCropper();
            $jcropper->thumbPath = $this->facePath;
            if(!file_exists($jcropper->thumbPath)) DxdUtil::createFolders($jcropper->thumbPath);

            $coords = $jcropper->getCoordsFromPost('imageId');
            $thumbnail = $jcropper->crop($model->face, $coords);
            if($thumbnail):
                $oldFace = $model->face;
                $model->face = $thumbnail;
                if($model->save()):
                    if($model->face != $oldFace) @unlink($oldFace);
                    Yii::app()->user->setFlash('success', '更新成功');
                    $this->redirect(array('index'));
                else:
                    Yii::app()->user->setFlash('error', '更新失败');
                endif;
            endif;
        }

        $this->render('crop_face', array(
            'model'     =>  $model,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return People the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=People::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param People $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='teacher-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
