<?php

class PageController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin/nonav_column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
		//	'accessControl', // perform access control for CRUD operations
		//		'postOnly + delete', // we only allow deletion via POST request
		'rights'
		);
	}


	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
/*	public function accessRules()
	{
		return array(
		array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','togglePublished'),
				'users'=>array('@'),
		),
		);
	}*/

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
	public function actionCreate($categoryId=0)
	{
		$model=new Page;
		$model->categoryId = $categoryId;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Page']))
		{
			$model->attributes=$_POST['Page'];
//			$model->categoryId=$_POST['Page']['categoryId'];
			$model->addTime = time();
			$model->userId = Yii::app()->user->id;
			if($model->save()){
				Yii::app()->user->setFlash('success','操作成功');
			}else{
				Yii::app()->user->setFlash('error','操作失败');
			}
			$this->redirect(array('index','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

    /**
     * 分类管理
     */
    public function actionCategory()
    {
        $model = new Category();
        $type = 'page';
        // 处理表单提交
        if (isset($_POST['Category'])) {
            if (Page::model()->addCategory($_POST['Category']['name'])) {
                Yii::app()->user->setFlash('success', '操作成功');
            } else {
                Yii::app()->user->setFlash('error', '操作成功');
            }
        }
        $this->render(
            'category',
            array(
                'model' =>  $model,
                'type'  =>  $type,
            )
        );
    }


	public function actionOrder($categoryId){
		if(isset($_POST['order'])){
			$ids = explode(",",$_POST['order']);
			for($i=0;$i<count($ids);$i++){
				if(DxdUtil::startWith($ids[$i], 'page-')){
					$id = substr($ids[$i], 5);
					$model =$this->loadModel($id);
					//$model->updateByPk( $id,array("weight"=>$i+1));
					$model->weight = $i+1;
					$model->save();
				}
			}
		}
	}
    /**
     * 更新分类
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
            'update_category',
            array(
                'model' =>  $model,
            )
        );
    }

    /**
     * 删除分类
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
	 * 发布/取消发布 页面
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function actionTogglePublished($id){
		$model = $this->loadModel($id);
		$model->published = $model->published>0 ? 0 :1;
		if($model->save()){
			if($model->published>0)
			Yii::app()->user->setFlash('success','发布成功');
			else
			Yii::app()->user->setFlash('success','取消发布成功');
		};
		$this->redirect(array('index'));

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Page']))
		{
			$model->attributes=$_POST['Page'];
			$model->categoryId=$_POST['Page']['categoryId'];
			if($model->save()){
				Yii::app()->user->setFlash('success','更新成功');
			}else{
				Yii::app()->user->setFlash('error','更新失败');
			}
			$this->redirect(array('index','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        if ($this->loadModel($id)->delete()) {
            Yii::app()->user->setFlash('success','操作成功');
            $this->redirect(array('index'));
        }

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if(isset($_POST['order'])){
			$idsString = $_POST['order'];
			$ids = explode(",",$idsString);
			for($i=0;$i<count($ids);$i++){
				$model = $this->loadModel($ids[$i]);
				if ($model)
				{
					$model->updateByPk( $ids[$i],array("weight"=>$i) );
				}

			}
			Yii::app()->end();
		}

		$dataProvider=new CActiveDataProvider('Page',array('criteria'=>array('order'=>'weight asc')));

		$this->render('index',array(
			'pageDataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Page('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Page']))
		$model->attributes=$_GET['Page'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Page the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Page::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Page $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='page-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
