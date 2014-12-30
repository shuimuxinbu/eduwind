<?php

class PhpemsModule extends WModule
{
    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'phpems.models.*',
        ));
        //$this->defaultController="nav";
    }
    public function getDisplayName(){
        return Yii::t('app',"连接PHPEMS");
    }

    public function getVersion(){
        return "1.0";
    }
    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }
}