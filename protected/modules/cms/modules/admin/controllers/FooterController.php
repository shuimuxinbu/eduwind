<?php

class FooterController extends Controller
{
	/**
	 * @var string 当前控制器视图的布局文件
	 */
	public $layout='//layouts/admin/nonav_column2';

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
            array(
                'allow',
                'roles' =>  array('admin'),
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    /**
     * 更新页面和处理方法
     * @param integer $id Id
     */
	public function actionIndex()
	{
        // 取得System_setting表中footer数据
        $model = new FooterForm();
        $model->getSetting();
        // 如果没有设置底部文本则使用默认值
        if (!isset($model->html)) {
			$model->setDefault();
        }

		if (isset($_POST['FooterForm']))
		{
			$model->attributes=$_POST['FooterForm'];
            // 如果表单验证成功
            if ($model->validate()) {
                if ($model->saveSetting()) {
                    Yii::app()->user->setFlash('success', '操作成功');
                    $this->redirect(array('index'));
                } else {
                    Yii::app()->user->setFlash('error', '操作失败');
                }
            }
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}

    /**
     * 恢复默认底部文本
     */
    public function actionRecover()
    {
        $model = new FooterForm();
        $model->getSetting();
		$model->setDefault();
        $model->validate();
        if ($model->saveSetting()) {
            Yii::app()->user->setFlash('success', '操作成功');
            $this->redirect(array('index'));
        } else {
            Yii::app()->user->setFlash('error', '操作失败');
        }
    }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SystemSetting the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SystemSetting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SystemSetting $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='system-setting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
