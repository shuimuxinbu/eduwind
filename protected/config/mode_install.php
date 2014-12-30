<?php

/**
 * Main configuration.
 * All properties can be overridden in mode_<mode>.php files
 */

return array(

	// Set yiiPath (relative to Environment.php)
//	'yiiPath' => dirname(__FILE__) . '/../../yii/framework/yii.php',
//	'yiicPath' => dirname(__FILE__) . '/../../yii/framework/yiic.php',
//	'yiitPath' => dirname(__FILE__) . '/../../yii/framework/yiit.php',

	// Set YII_DEBUG and YII_TRACE_LEVEL flags
	'yiiDebug' => true,
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
		'name'=>'EduWind',
		'theme'=>'classic',
	
		// preloading 'log' component
		'preload'=>array('log'),
	//	'theme'=>'bootstrap',
		// autoloading model and component classes
		'import'=>array(
			'application.models.*',
			'application.components.*',
			'application.components.behaviors.*',
			'application.modules.rights.*',
			'application.modules.rights.components.*',
			'application.extensions.taggable-behavior-master.*',
			'application.modules.admin.models.*',
			'editable.*',
		),
		'aliases'=>array(
			'xupload' => 'ext.xupload',
		),
		'language'=>'zh_cn',
		'defaultController'=>'install',
		'modules'=>array(
			// uncomment the following to enable the Gii tool
			
/*			'rights'=>array( 
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
			),*/
		//	'install'=>array(),
		//	'admin'=>array(),

			
		),
	
		// application components
		'components'=>array(
			'user'=>array(
				// enable cookie-based authentication
				'allowAutoLogin'=>true,
				'class'=>'RWebUser',
				//'class' => auth.components.AuthWebUser',
				'loginUrl'=>array('//u/login')
			),
			  'bootstrap'=>array(
	            'class'=>'bootstrap.components.Bootstrap',
	        ),
	        'cache'=>array(
	     	   'class'=>'system.caching.CFileCache'
	        ),
	        'authManager'=>array(
	        	'class'=>'RDbAuthManager',
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
			
		/*	'urlManager'=>array(
				'urlFormat'=>'path',
				 'showScriptName'=>true,
				'rules'=>array(
					'<controller:\w+>/<id:\d+>'=>'<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
					'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				),
			),	*/
		//	'db'=>include(dirname(__FILE__).DIRECTORY_SEPARATOR."../data/db.php"),


		),
	
		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params'=>array(
			// this is used in contact page
			'adminEmail'=>'webmaster@example.com',
			'settings'=>include(dirname(__FILE__).DIRECTORY_SEPARATOR."../data/settings.php"),	
		),
	),

);