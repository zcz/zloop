<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
	
	// preloading 'log' component
	'preload'=>array('log'),
	
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.yii-mail.YiiMailMessage',
	),
	// application components
	'components'=>array(

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dbzloop',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '89622',
			'charset' => 'utf8',
			'tablePrefix' => 'tb_',
		),

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
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					"class"=>"CFileLogRoute",
					"levels"=>'info',
					"categories"=>"application.*",
					//open the path for production
					"logPath"=>"/var/log/zloop/",
					"logFile"=>"console.log",
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
					"logTableName" => "z_log_console",
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
	),
	
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
		
		'expirePeriod' => 60 * 60 * 24 * 30,
		'expireNotificationBefore' => 60 * 60 * 24 * 5,
		'conditionExpired' => 203,
		'conditionClean' => 2,
		'removeAfterTime' => 60 * 60 * 24 * 30,
		
		//for share to different platforms
		'weibo_id' => '2644009563',
	),
);


