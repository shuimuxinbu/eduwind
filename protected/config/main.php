<?php

/**
 * Main configuration.
 * All properties can be overridden in mode_<mode>.php files
 */
include_once 	dirname(__FILE__).'/../components/functions.php';

$config = array(

// Set yiiPath (relative to Environment.php)
	'yiiPath' => dirname(__FILE__) . '/../../yii/framework/yii.php',
	'yiicPath' => dirname(__FILE__) . '/../../yii/framework/yiic.php',
	'yiitPath' => dirname(__FILE__) . '/../../yii/framework/yiit.php',

// Set YII_DEBUG and YII_TRACE_LEVEL flags
	'yiiDebug' => false,
	'yiiTraceLevel' => 0,

// Static function Yii::setPathOfAlias()
	'yiiSetPathOfAlias' => array(
		'bootstrap'=> dirname(__FILE__).'/../extensions/bootstrap/',
		'editable'=> dirname(__FILE__).'/../extensions/x-editable'
		// uncomment the following to define a path alias
//'local' => 'path/to/local-folder'
),

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
	'configWeb' => array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
//'name'=>'EduWind',
		'theme'=>'default',

// preloading 'log' component
		'preload'=>array('log', 'booster'),
//		'language'=>'zh-cn',
//	'theme'=>'bootstrap',
// autoloading model and component classes
		'import'=>array(
			'application.models.*',
			'application.components.*',
			'application.components.behaviors.*',
			'application.components.vendors.payment.alipay.*',
  		     'application.modules.rights.components.dataproviders.*',
			'application.modules.rights.*',
			'application.modules.admin.models.*',
			'application.modules.rights.components.*',
			'application.extensions.taggable-behavior-master.*',
			'editable.*',
            'booster.helpers.*',
),
		'aliases'=>array(
			'xupload' => 'ext.xupload',
            'booster' =>  'ext.booster',
),
		'language'=>'zh-CN',
		'sourceLanguage'=>'zh_cn',
		'defaultController'=>'site',
		'modules'=>array(
// uncomment the following to enable the Gii tool

			'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'000000',
// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters'=>array('127.0.0.1','::1'),
				'generatorPaths'=>array(  //添加一个gii检索的路径
			                'booster.gii',
)
),
			'rights'=>array(
				'superuserName'=>'admin', //在authassignment中指定了userId的用户为可以进入rights的超级管理员
				'authenticatedName'=>'Authenticated',
				'userIdColumn'=>'id',
				'userNameColumn'=>'email',
				'enableBizRule'=>true,
				'enableBizRuleData'=>false,
				'displayDescription'=>true,
				'flashSuccessKey'=>'RightsSuccess',
				'flashErrorKey'=>'RightsError',
				'install'=>false,
				'baseUrl'=>'/rights',
				'debug'=>true,
),
			'lab'=>array(),
			'course'=>array(),
			'admin'=>array(),
			'group'=>array(),
			'cms'=>array(),
            'phpems'=>array(),
		//	'courseAdmin'=>array(),
		//	'rank' => array(),
		//	      'class' => 'application.modules.Rank.RankModule'
			//      ),
      /*'auth'=>array(
       'strictMode' => true, // when enabled authorization items cannot be assigned children of the same type.
       'userClass' => 'User', // the name of the user model class.
       'userIdColumn' => 'id', // the name of the user id column.
       'userNameColumn' => 'email', // the name of the user name column.
       'defaultLayout' => 'application.views.layouts.main', // the layout used by the module.
       'viewDir' => null, // the path to view files to use with this module.
       ),*/

      ),

      // application components
		'components'=>array(
      /*		'courseCategory'=>array(
       'class'=>'CourseCategorySingleton'
       ),*/
			'user'=>array(
      // enable cookie-based authentication
				'allowAutoLogin'=>true,
				'class'=>'RWebUser',
      //'class' => auth.components.AuthWebUser',
				'loginUrl'=>array('//u/login')
      ),
            'session' => array(
                'class' => 'EwDbHttpSession',
                'connectionID' => 'db',
                //'timeout'=>'1440',
            ),
            'bootstrap' =>  array(
                'class' =>  'booster.components.Booster',
            ),
			  'booster'=>array(
	            'class'=>'booster.components.Booster',
      ),
	        'cache'=>array(
	     	   'class'=>'system.caching.CFileCache'
	     	   ),
	        'authManager'=>array(
	        	'class'=>'RDbAuthManager',
	             'defaultRoles'=>array('Authenticated'),

	     	   ),
	     	   /*'authManager'=>array(
	     	    //'class'=>'RDbAuthManager',
	     	    'class' => 'CDbAuthManager',
	     	    'behaviors' => array(
	     	    'auth' => array(
	     	    'class' => 'auth.components.AuthBehavior',
	     	    'admins' => array('liangjh08@gmail.com'),
	     	    ),
	     	    ),
	     	    ),*/
	     	   // uncomment the following to enable URLs in path-format


	     	   /*
	     	    'db'=>array(
	     	    'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	     	    ),*/
	     	   // uncomment the following to use a MySQL database

			'db'=>include(dirname(__FILE__).DIRECTORY_SEPARATOR."../data/db.php"),

			'errorHandler'=>array(
	     	   // use 'site/error' action to display errors
				'errorAction'=>'site/error',
	     	   ),
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
			     	   array(
								'class'=>'CFileLogRoute',
								'levels'=>'error, warning',
			     	   ),
						array(
                        'class'=>'EwDbLogRoute',
                        'connectionID'=>'db',

                        'logTableName' => 'ew_log',
                        'levels'=>'error, warning, info',
                        'categories'=>'ew.*',
                    	),

	     	   // uncomment the following to show log messages on web pages
	     	   /*
	     	   array(
	     	   'class'=>'CWebLogRoute',
	     	   ),
	     	   */
	     	   ),
	     	   ),

	     	   /**
	     	    * htmldiff
	     	    */
			'htmldiff'=>array(
					'class'=>'application.extensions.htmldiff.HtmlDiff',
	     	   ),

	     	   //X-editable config
			'editable' => array(
					'class'     => 'editable.EditableConfig',
					'form'      => 'bootstrap',        //form style: 'bootstrap', 'jqueryui', 'plain'
					'mode'      => 'popup',            //mode: 'popup' or 'inline'
					'defaults'  => array(              //default settings for all editable elements
							'emptytext' => 'Click to edit'
							)
							),
							),

							// application-level parameters that can be accessed
							// using Yii::app()->params['paramName']
		'params'=>array(
							// this is used in contact page
			'adminEmail'=>'webmaster@example.com',
			'settings'=>include(dirname(__FILE__).DIRECTORY_SEPARATOR."../data/settings.php"),
							),
							),

							// This is the Console application configuration. Any writable
							// CConsoleApplication properties can be configured here.
							// Leave array empty if not used.
							// Use value 'inherit' to copy from generated configWeb.
	'configConsole' => array(

		'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name' => 'My Console Application',

							// Preloading 'log' component
		'preload' => array('log', 'booster'),

							// Autoloading model and component classes
		'import'=>'inherit',

							// Application componentshome
		'components'=>array(

							// Database
			'db'=>'inherit',

							// Application Log
			'log' => array(
				'class' => 'CLogRouter',
				'routes' => array(
							// Save log messages on file
							array(
						'class' => 'CFileLogRoute',
						'levels' => 'error, warning, trace, info',
				        ),
                    /*
                    array(
                        'class'    => 'CFileLogRoute',
                        'levels'   => 'error, warning, info, trace',
                        'logFile' => 'console.log',
                        'categories'=>'system.db.*',
                    ),
                    array(
                        'class'=>'CDbLogRoute',
                        'connectionID'=>'db',
                        'logTableName' => 'ew_logs',
                        'levels'=>'error, warning, trace, info',
                        'categories'=>'eduwind.*',
                    ),
                    */
		),
	),

),
	),

);
global $sysSettings;
if(isset($sysSettings['site']['urlFormat']) && $sysSettings['site']['urlFormat']=="path"){
		$config['configWeb']['components']['urlManager']=array(
				'urlFormat'=>'path',
				 'showScriptName'=>false,
				'rules'=>array(
					'<controller:\w+>/<id:\d+>'=>'<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
					'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
								//		'<controller:\w+>/<action:\w+>'=>'<controller>/default/<action>',
								//		'<module:\w+>/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				//	'<module:\w+>/<controller:(index)>/<action:\w+>'=>'<module>/<action>',
				//	'<module:\w+>/<controller:(index)>/<id:\d+>'=>'<module>/view',
								),
								);
}
if(isset($sysSettings['theme']['name']) && $sysSettings['theme']['name']){
			$config['configWeb']['theme']=$sysSettings['theme']['name'];
}
if(isset($sysSettings['site']['name']) && $sysSettings['site']['name']){
			$config['configWeb']['name']=$sysSettings['site']['name'];
}
//error_log(print_r($sysSettings,true));
//error_log(print_r($config['configWeb']['components'],true));
							return $config;
