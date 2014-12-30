<?php

// set environment
require_once(dirname(__FILE__) . '/../../protected/extensions/yii-environment/Environment.php');
$env = new Environment('TEST'); //override mode

// run Yii app
require_once($env->yiitPath);
require_once(dirname(__FILE__).'/WebTestCase.php');
$env->runYiiStatics(); // like Yii::setPathOfAlias()
Yii::createWebApplication($env->configWeb);
