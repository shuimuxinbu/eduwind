<?php

class PeopleController extends Controller
{
    /**
     * @var string 当前控制器视频的布局文件
     */
    public $layout = '//layouts/column1';

	// Uncomment the following methods and override them if needed
	public function filters()
	{
		return array(
            'accessControl',
		);
	}

    public function accessRules()
    {
        return array();
    }


    /**
     * 控制器默认方法,列出所有的人员
     */
	public function actionIndex($categoryId=0)
	{
		$categoryId = intval($categoryId);
        $categoryId!==0 ? $where="={$categoryId}" : $where=" is not null";
        $dataProvider = new CActiveDataProvider(
            'People',
            array(
                'criteria'  =>  array(
                    'condition' =>  'categoryId' . $where,
                    'with'      =>  array('user'),
                )
            )
        );
        // 人员分类
        $categoryData = Category::model()->findAll(
            array(
                'condition' =>  'type="teacher"',
                'order'     =>  'weight ASC',
            )
        );
        $categorys[0]['label']   =   Yii::t('app','全部');
        $categorys[0]['url']     =   array('index');
        $categorys[0]['active']  =   isset($_GET['categoryId']) ? false : true;
        foreach ($categoryData as $k=>$v) {
            $categorys[$k+1]['label']   =   $v->name;
            $categorys[$k+1]['url']     =   array('index', 'categoryId'=>$v->id);
            $categorys[$k+1]['active']  =   isset($_GET['categoryId']) && $_GET['categoryId']===$v->id ? true : false;

        }
		$this->render(
            'index',
            array(
                'categorys'     =>  $categorys,
                'dataProvider'  =>  $dataProvider,
            )
        );
	}

}
