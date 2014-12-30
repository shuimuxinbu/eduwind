<?php

class LogController extends RController
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
            //			'postOnly + delete', // we only allow deletion via POST request
            'rights',

        );

    }


    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model=new Log('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Log']))
            $model->attributes=$_GET['Log'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }

}
