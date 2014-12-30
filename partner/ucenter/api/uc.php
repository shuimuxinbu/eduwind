<?php

define('UC_CLIENT_VERSION', '1.5.0');	//note UCenter 版本标识
define('UC_CLIENT_RELEASE', '20081031');

define('API_DELETEUSER', 1);		//note 用户删除 API 接口开关
define('API_RENAMEUSER', 1);		//note 用户改名 API 接口开关
define('API_GETTAG', 1);		//note 获取标签 API 接口开关
define('API_SYNLOGIN', 1);		//note 同步登录 API 接口开关
define('API_SYNLOGOUT', 1);		//note 同步登出 API 接口开关
define('API_UPDATEPW', 1);		//note 更改用户密码 开关
define('API_UPDATEBADWORDS', 1);	//note 更新关键字列表 开关
define('API_UPDATEHOSTS', 1);		//note 更新域名解析缓存 开关
define('API_UPDATEAPPS', 1);		//note 更新应用列表 开关
define('API_UPDATECLIENT', 1);		//note 更新客户端缓存 开关
define('API_UPDATECREDIT', 1);		//note 更新用户积分 开关
define('API_GETCREDITSETTINGS', 1);	//note 向 UCenter 提供积分设置 开关
define('API_GETCREDIT', 1);		//note 获取用户的某项积分 开关
define('API_UPDATECREDITSETTINGS', 1);	//note 更新应用积分设置 开关

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');

define('DISCUZ_ROOT', '../');


require_once(dirname(__FILE__) . '/../../../protected/extensions/yii-environment/Environment.php');



//$env = new Environment();

$env = new Environment('PRODUCTION'); //override mode
$env->yiicPath = dirname(__FILE__).'/../../../yii/framework/yii.php'; 

define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
// run Yii app
//$env->showDebug(); // show produced environment configuration
require_once($env->yiiPath);

$env->runYiiStatics(); // like Yii::setPathOfAlias()
require(dirname(__FILE__).'/../../../protected/components/UcenterApplication.php');  
$ucenterPath = dirname(__FILE__)."/../";

require_once ($ucenterPath.'/config.inc.php');
require_once($ucenterPath.'/uc_client/client.php');
Yii::createApplication('UcenterApplication',$env->configWeb)->run();
