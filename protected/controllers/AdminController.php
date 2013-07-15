<?php

class AdminController extends ZLOOPController
{
	public function init() {
		//add this controller's title
		parent::init();
		$this->addToTitle("Admin");
	}
	
	public function filters()
	{
		return array(
			'admin_control',
		);
	}
	
	public function filterAdmin_control($filterChain) {
		if (Yii::app()->user->isGuest || Yii::app()->user->id != Yii::app()->params['adminAccountNumber'])
		{
			echo "not admin, bye";
			return false;
		}
		$filterChain->run();
	}	
	
	public function actionBlockEmail($email)
	{
		if (isset($email)) {
			$user=User::model()->findByEmail($email);	
			if (isset($user)) {
				$user->sendWeeklyEmail = false;
				$user->save(false, array("sendWeeklyEmail", "last_modified"));
				echo "blocked<br>email : " . $email . "<br> uid : ".$user->id;
				Yii::log("blocked email:" . $email . "; uid:".$user->id);
			} else {
				echo "not find email : ".$email;
			}		
		}
	}

	public function actionIndex()
	{
		echo "passed, I assume you know what you are going to do, do it carefully.<br>";
		echo "you may: <br>";
		echo "/blockEmail&email=demo@gmail.com<br>";
	}
}