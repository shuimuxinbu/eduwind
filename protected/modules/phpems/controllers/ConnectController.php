<?php

class ConnectController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';
    private $_sc = 'exam@phpems.net';    //密钥，保留在本地程序，保持双方一致
    private $_phpemsurl = 'http://localhost/phpems/index.php?exam-api-login';


    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operation
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
                'actions'=>array('gotoPhpems'),
                'users'=>array('@'),
            ),

            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionGotoPhpems()
    {
        //取得user
        $user = UserInfo::model()->findByPk(Yii::app()->user->id);
        //准备参数
        $userid = $user->id; //用户ID
        $username = $user->name; //用户名，GET方式过来
        $email = $user->email;   //邮箱，GET方式过来

        $ts = time();
        $sign = md5($userid.$username.$email.$this->_sc.$ts);

        //跳转到phpems
        $this->redirect($this->_phpemsurl.'&userid='.$userid.'&username='.$username.'&useremail='.$email.'&ts='.$ts.'&sign='.$sign);
        //$this->redirect($this->_phpemsurl,array('exam-api-login'=>'','userid'=>$userid,'username'=>$username,'useremail'=>$email,'ts'=>$ts,'sign'=>$sign));
    }

}
