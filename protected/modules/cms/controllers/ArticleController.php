<?php

class ArticleController extends Controller
{
    /**
	 * @var string 当前控制器视图的布局文件
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
                'actions'=>array('addComment', 'deleteComment'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * 关联外部动作
     * @return array 外部动作
     */
    public function actions()
    {
        return array(
            'toggleFollow'=>array(
                'class'=>'application.components.actions.ToggleFollowAction',),
            'addComment'=>array(
                'class'=>'application.components.actions.commentable.AddCommentAction',
            ),
            'toggleVote'=>array(
                'class'=>'application.components.actions.ToggleVoteAction',
        ));
    }

    /**
     * 文章内容页
	 * @param integer $id 文章ID
	 */
    public function actionView($id)
    {
        // 浏览页面viewNum+1
        $model = $this->loadModel($id);
        $model->viewNum =   $model->viewNum+1;
        $model->save();

        // 热点新闻
        $hotArticleDataProvider = new CActiveDataProvider('Article', array(
            'criteria'  =>  array(
                'order' =>  'viewNum DESC, id DESC',
            ),
            'pagination'    =>  array(
                'pageSize'  => 6,
            ),
        ));
        $this->render('view',array(
            'model' =>   $model,
            'hotArticleDataProvider' =>  $hotArticleDataProvider,
        ));
    }

    /**
     * 首页页
     * @param integer $categoryId 文章分类ID
	 */
    public function actionIndex($categoryId=0)
    {
        // SQL条件
        $categoryId = intval($categoryId);
        $categoryId!=0 ? $where="={$categoryId}" : $where = ' is not null';
        // 所有新闻
        $dataProvider=new CActiveDataProvider('Article', array(
            'criteria'  =>  array(
                'order' =>  'isTop DESC, id DESC',
                'condition' =>  'categoryId' . $where,
            ),
            'pagination'    =>  array(
                'pageSize'  =>  10,
            ),
        ));
        // 热点新闻
        $hotArticleDataProvider = new CActiveDataProvider('Article', array(
            'criteria'  =>  array(
                'order' =>  'isTop DESC, viewNum DESC, id DESC',
                'condition' =>  'categoryId' . $where,
            ),
            'pagination'    =>  array(
                'pageSize'  => 6,
            ),
        ));
        // 文章分类
        $categorysData = Category::model()->findAll(
            array(
                'condition' =>  'type="article"',
                'order'     =>  'weight ASC',
            )
        );
        $categorys[0]['label']   =   Yii::t('app','全部');
        $categorys[0]['url']     =   array('article/index');
        $categorys[0]['active']  =   !isset($categoryId) || $categoryId==0 ? true : false;
        foreach ($categorysData as $k=>$v) {
            $categorys[$k+1]['label'] =   $v->name;
            $categorys[$k+1]['url']   =   array('article/index', 'categoryId'=>$v->id);
            $categorys[$k+1]['active']=   $categoryId==$v->id ? true : false;
        }

        $this->render(
            'index',
            array(
                'dataProvider'  =>  $dataProvider,
                'hotArticleDataProvider'    =>  $hotArticleDataProvider,
                'categorys'     =>  $categorys,
            )
        );
    }

    /**
     * 删除评论功能
     * @param integer $id        文章ID
     * @param integer $commentId 评论ID
     */
    public function actionDeleteComment($id,$commentId)
    {
        if (Comment::model()->findByPk($commentId)->delete()) {
           Yii::app()->user->setFlash('success',Yii::t('app','删除成功'));
        } else {
            Yii::app()->user->setFlash('error',Yii::t('app','删除失败'));
        }
        $this->redirect(array('view','id'=>$id));
    }

    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Article the loaded model
	 * @throws CHttpException
	 */
    public function loadModel($id)
    {
        $model=Article::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');

        return $model;
    }

    /**
	 * Performs the AJAX validation.
	 * @param Article $model the model to be validated
	 */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax']==='Article-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
