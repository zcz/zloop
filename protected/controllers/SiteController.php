<?php

class SiteController extends ZLOOPController
{	
	
	public function init() {
		//add this controller's title
		parent::init();
		$this->addToTitle("");
	}
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	public function actionPageMissing() {
		//add this action's title
		$this->addToTitle("Error");
		$this->renderPartial('/site/pages/simpleError');
	}

	/*
	 * just for test
	 */
	public function actionTest()
	{
		$this->addToTitle("Test");		
		Yii::log("testing... ");
		$item = Item::model()->findByPk(2);
		$this->renderPartial("/email/partialItemExpireNotification", array('item'=>$item));
	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->addToTitle("");
		$keys = new SearchKeysForm;
		
		if(isset($_POST['SearchKeysForm']))
		{
			$keys->attributes=$_POST['SearchKeysForm'];
			$this->redirect(array("/item/index", "keywords"=>$keys->keyString));
		}
		
		echo $this->render('index', array('keys'=>$keys));
		Yii::log("visiting home page");
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->addToTitle("Error");
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else {
	    		$this->renderPartial('/site/pages/simpleError');
	    	}
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$this->addToTitle("Contact");
		$model=new ContactForm;
		
		if (!Yii::app()->user->isGuest)
		{
			$me = User::model()->findByPk(Yii::app()->user->id);
			$model->email = $me->email;
			$model->name = $me->username;
		}
		
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$mailSender = new EmailSending();
				$mailSender->sendFeedBackEmail($model);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				Yii::log("user left a feedback");
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
	
	/**
	* Displays the forget password page, if success send change password link
	*/
	public function actionForgetPassword()
	{
		$this->addToTitle("Forget Password");
		$model=new ForgetPasswordForm;
	
		if(isset($_POST['ForgetPasswordForm']))
		{
			$model->attributes=$_POST['ForgetPasswordForm'];
			if($model->validate())
			{
				$mailSender = new EmailSending();
				$mailSender->sendForgetPasswordEmail($model->email);
				Yii::app()->user->setFlash('forgetPassword','A email has been sent to <b>' . $model->email . "</b>. Please follow the instruction in it to reset your password.");
				Yii::log("user reset password, email: " . $model->email);
				$this->refresh();
			}
		}
		$this->render('forgetPassword',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->addToTitle("Sign in");
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				// user log in
				Yii::log("user log in");
				$this->redirect(Yii::app()->user->returnUrl);
			} 
			else
			{
				// log for failed login attempt, without password, for security reason
				Yii::log("login faild: email:$model->username");
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	/**
	* Displays the login page
	*/
	public function actionLoginSimple()
	{
		$this->addToTitle("Sign in");
		$model=new LoginForm;
	
		if(isset($_POST['LoginForm'])) {
			$model->attributes=$_POST['LoginForm'];
			if($model->validate() && $model->login()) {
				Yii::log("user log in from simple log in");
				echo "success, hello " . $model->username;
			}
			else {
				Yii::log("login faild: email:$model->username");
				echo "failed";
			}
		} else {
			$this->renderPartial('login_simple' , array('model'=>$model));
		}
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		$this->addToTitle("Sign out");
		Yii::log("user log out");
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionTagCloud()
	{
		$this->addToTitle("Tag Cloud");
		$this->render("tagCloud");
		Yii::log("access tag Cloud");
	}
	
	public function actionHelp()
	{
		$this->addToTitle("Help");
		$this->render("pages/help");
		Yii::log("help page viewed");
	}
	
	public function actionAbout()
	{
		$this->addToTitle("About");
		$this->render("pages/about");
		Yii::log("AboutUs page viewed");
	}
	
	public function actionDownloadVideo()
	{
		$this->addToTitle("Video");
		$this->renderPartial("pages/introVideo");
		Yii::log("introduction video downloaded");
	}
	
	public function actionServiceTerms()
	{
		$this->addToTitle("Service Terms");
		$this->renderPartial("pages/ServiceTerms");
		Yii::log("service terms viewed");	
	}
	
	public function actionPrivacyPolicy()
	{
		$this->addToTitle("Privacy Policy");
		$this->renderPartial("pages/PrivacyPolicy");
		Yii::log("privacy policy viewed");	
	}
}