<?php

//class IndexController extends AbleController
class ArticleController extends CController
{
    /**
     * @var string 当前控制器视图的布局文件
     */
	public $layout='//layouts/admin/nonav_column2';

    /**
     * @var string 文章封面存储路径
     */
    private $facePath = 'uploads/Article/face/thumbs/';

    /**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
    public function accessRules()
    {
        return array(
            array('allow',
                'roles'=>array('admin')
            ),
            array('deny',  // deny all users
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
     * 过滤控制
     * @return array 过滤
     */
    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'accessControl',
        );
    }

    /**
	 *  新闻列表页面
	 */
    public function actionIndex()
    {
        $model = new Article('search');
        $model->unsetAttributes();
        if (isset($_GET['Article'])) {
            $model->attributes = $_GET['Article'];
        }
        $this->render('index', array('model'=>$model));
    }

    /**
     * 删除新闻处理
     * @param integer $id 文章ID
     */
    public function actionDelete($id)
    {
        if($this->loadModel($id)->delete()):
            Yii::app()->user->setFlash('success', '删除成功');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        else:
            Yii::app()->user->setFlash('error', '删除失败');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        endif;
    }

    /**
     * 更新新闻页面和处理方法
     * @param integer $id 文章ID
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Article'])) {
            $model->attributes = $_POST['Article'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '操作成功');
                $this->redirect(array('index'));
            }
        }
        $this->render('update', array('model'=>$model));
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
     * 添加新闻页面和处理方法
     */
    public function actionCreate()
    {
        $model = new Article();

        if (isset($_POST['Article'])) {
            $model->attributes = $_POST['Article'];
            $model->uid = Yii::app()->user->id;
            $model->addTime = time();
            $model->upTime = time();
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '操作成功');
                $this->redirect(array('uploadFace', 'id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', '操作失败');
            }
        }
        $this->render('create',array('model'=>$model));
    }

    /**
     * 文章分类页面和文章分类添加排序操作
     */
    public function actionCategory()
    {
        $model = new Category();
        $type = 'article';
        // 处理表单提交
        if (isset($_POST['Category'])) {
            $model->attributes = $_POST['Category'];
            if ($model->save()) $this->redirect(array('category'));
        }
        $this->render('category', array(
            'model'     =>  $model,
            'type'      =>  $type,
        ));
    }

    /**
     * 更新文章分类页面和处理
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
     * 删除文章分类处理
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
     * 置顶操作
     * @param integer $id    文章ID
     * @param integer $isTop 1=置顶，0=取消置顶
     */
    public function actionSetTop($id, $isTop)
    {
        $model = $this->loadModel($id);
        $model->isTop = $isTop;
        if ($model->save()) Yii::app()->user->setFlash('success', '操作成功');
        $this->redirect(array('index'));
    }

    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
    public function loadModel($id)
    {
        $model=Article::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');

        return $model;
    }

}
