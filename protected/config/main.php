<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ZLOOP',
	'defaultController'=>'site',
	'theme'=>'classic',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.yii-mail.YiiMailMessage',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'89622',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
		/*
		 * 1. to prevent the CSRF attack, add random number in cookie
		 * 2. to prevent cookie attack, check MAC address
		 */
		'request'=>array(
			// seems there is some problems when using this function, so diable first
			// still use, untill next report error
			//'enableCsrfValidation'=>true,
			//'enableCookieValidation'=>true,
			//turn off for developing
			'enableCsrfValidation'=>false,
			'enableCookieValidation'=>false,

		),
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dbzloop',
			'emulatePrepare' => true,
			'username' => 'root',
			//change the password for production
			'password' => '89622',
			'charset' => 'utf8',
			'tablePrefix' => 'tb_',
		),
		
		'backupDB'=>array(
			'class' => "CDbConnection",
			'connectionString' => 'mysql:host=localhost;dbname=dbzloop',
			'emulatePrepare' => true,
			'username' => 'root',
			//change the password for production
			'password' => '89622',
			'charset' => 'utf8',
			'tablePrefix' => '',
		),

/*
		//the mail method that use extension to send out emails
		'mail' => array(
 			'class' => 'ext.yii-mail.YiiMail',
 			'transportType' => 'smtp',
 			'viewPath' => 'application.views.email',
 			'logging' => false,
 			'dryRun' => false,
			'transportOptions' => array (
				'host'=>'smtp.gmail.com',
            	'username'=>'hongkong.zhangchenzi@gmail.com',
	            'password'=>'zcz1989622zcz',
   	    	    'port'=>'465',
   		        'encryption'=>'ssl',
			),
		),
*/

		//the mail method that use extension to send out emails, used for zloop.net
		'mail' => array(
 			'class' => 'ext.yii-mail.YiiMail',
 			'transportType' => 'smtp',
 			'viewPath' => 'application.views.email',
 			'logging' => true,
 			'dryRun' => false,
			'transportOptions' => array (
				'host'=>'localhost',
				'port'=>25,
			),
		),

/*
		//use php's function to send email
		'mail' => array(
                        'class' => 'ext.yii-mail.YiiMail',
                        'transportType' => 'php',
                        'viewPath' => 'application.views.email',
                        'logging' => true,
                        'dryRun' => false,
                ),
*/

		'errorHandler'=>array(
			// use 'site/error' action to display errors
            		'errorAction'=>'site/error',
        	),
 
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					"levels"=>"warning, error",
					//open the path for production
					"logPath"=>"/var/log/zloop/",
					"logFile"=>"error.log",
					"maxFileSize"=>"1024",
					"maxLogFiles"=>"100",
				),
				array(
					"class"=>"CDbLogRoute",
					"levels"=>"warning, error",
					"autoCreateLogTable"=>true,
					"connectionID" => "db",
					"logTableName" => "z_log_error",
				),
				array(
					"class"=>"CFileLogRoute",
					"levels"=>'info',
					"categories"=>"application.*",
					//open the path for production
					"logPath"=>"/var/log/zloop/",
					"logFile"=>"info.log",
					"maxFileSize"=>"1024",
					"maxLogFiles"=>"100",
					"filter"=>"SimpleLogFilter",
				),
				array(
					"class"=>"CDbLogRoute",
					"levels"=>'info',
					"categories"=>"application.*",
					"autoCreateLogTable"=>true,
					"connectionID" => "db",
					"logTableName" => "z_log_info",
					"filter"=>"SimpleLogFilter",
				),
				array(
					"class"=>"CFileLogRoute",
					"levels"=>'info',
					"categories"=>"ext.*",
					//open the path for production
					"logPath"=>"/var/log/zloop/",
					"logFile"=>"email.log",
					"maxFileSize"=>"1024",
					"maxLogFiles"=>"100",
					"filter"=>"SimpleLogFilter",
				),
				array(
					"class"=>"CDbLogRoute",
					"levels"=>'info',
					"categories"=>"ext.*",
					"autoCreateLogTable"=>true,
					"connectionID" => "db",
					"logTableName" => "z_log_email",
					"filter"=>"SimpleLogFilter",
				),
			),
		),
		
		'urlManager'=>array(
				'urlFormat'=>'path',
				'rules'=>array(
						// REST patterns
						array('api/login', 'pattern'=>'api/login', 'verb'=>'POST'),
						array('api/checkSession', 'pattern'=>'api/checkSession'),
						array('api/list', 'pattern'=>'api/<model:\w+>', 'verb'=>'GET'),
						array('api/view', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'GET'),
						array('api/update', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'PUT'),
						array('api/delete', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'DELETE'),
						array('api/create', 'pattern'=>'api/<model:\w+>', 'verb'=>'POST'),
						// Other controllers
						#'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				),
		),
		
/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'http://www.zloop.net/email/<action>' => 'email/<action>',
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				//'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),*/
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'sitePort' => '80',
		'adminEmail' => 'myzloop@gmail.com',
		'openEmail'  => 'info@zloop.net',
		
		'categoryCreate' => 1,
		'categorySold' => 201,
		'categoryBaseSet' => 0,
		'conditionBaseSet' => 0,
		'defaultViewCondition' => 1,
		
		'specialAction_view' => 'viewed',
		'specialAction_null' => 'null',
		'specialAction_commented' => 'commented',
		'adminAccountNumber' => 1,
		
		'expirePeriod' => 60 * 60 * 24 * 30 * 3,
		'expireNotificationBefore' => 60 * 60 * 24 * 5,
		'conditionExpired' => 203,
		'conditionClean' => 2,
		'removeAfterTime' => 60 * 60 * 24 * 30 * 3,
		
		//for share to different platforms
		'weibo_id' => '2644009563',
	),
);
