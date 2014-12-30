<?php
// change the following paths if necessary  
$yii=dirname(__FILE__).'/../../../protected/extensions/yii-environment/Environment.php';  
$config=dirname(__FILE__).'/../../../protected//config/main.php';  
  
// remove the following lines when in production mode  
defined('YII_DEBUG') or define('YII_DEBUG',true);  
// specify how many levels of call stack should be shown in each log message  
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);  
  
require_once($yii);  
require(dirname(__FILE__).'/../../../protected/components/UcenterApplication.php');  
Yii::createApplication('UcenterApplication', $config)->run(); 
