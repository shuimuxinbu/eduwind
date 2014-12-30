<?php
/*
 // change the following paths if necessary
 $yii=dirname(__FILE__).'/yii/framework/yii.php';
 $config=dirname(__FILE__).'/protected/config/main.php';

 // remove the following lines when in production mode
 defined('YII_DEBUG') or define('YII_DEBUG',true);
 // specify how many levels of call stack should be shown in each log message
 defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

 require_once($yii);
 Yii::createWebApplication($config)->run();

 */


// set environment
 require_once(dirname(__FILE__) . '/protected/extensions/yii-environment/Environment.php');
//$env = new Environment();

 $sysSettings = include (dirname(__FILE__).'/protected/data/settings.php');
 if(isset($sysSettings['site']['install']) && !$sysSettings['site']['install']){	
	$env = new Environment('PRODUCTION'); //override mode
}else{
	$env = new Environment('INSTALL'); //override mode	
}
// set debug and trace level
defined('YII_DEBUG') or define('YII_DEBUG', $env->yiiDebug);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', $env->yiiTraceLevel);

// run Yii app
//$env->showDebug(); // show produced environment configuration
require_once($env->yiiPath);
date_default_timezone_set('PRC');
//define("SETTINGS",include (dirname(__FILE__).'/protected/data/settings.php'));

$env->runYiiStatics(); // like Yii::setPathOfAlias()
Yii::createWebApplication($env->configWeb)->run();



