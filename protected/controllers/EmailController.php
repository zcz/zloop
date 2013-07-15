<?php

class EmailController extends ZLOOPController
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'emailAuthen'
				'actions'=>array('testEmail', 'testView'),
				'users'=>array('*'),
			),
			array('allow',  // allow all users to perform 'emailAuthen'
				'actions'=>array(
					'waitConfirm', 
					'emailConfirm', 
					'errorSendEmail', 
					'confirmFinished',
					'confirmFailed',
					'changePassword',
					'unsubscribeWeeklyNews'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionWaitConfirm()
	{
		$this->render('txtWaitConfirm');
	}
	
	public function actionConfirmFinished()
	{
		$this->render("txtConfirmFinished");
	}
	
	public function actionConfirmFailed()
	{
		$this->render("txtConfirmFailed");
	}

	public function actionEmailConfirm()
	{
		$model = $this->getData_id_code( new User_D() );
		$model_existed = User::model()->findByEmail($model->email);
		if ($model_existed != null) {
			$model_existed->password = $model->password;
			$model_existed->salt = $model->salt;
			$model_existed->save(false);
		} else {
			$model->reverseDelete();
		}
		$user = User::model()->findByEmail($model->email);
		$user->encode_password = true;
		$user->save(false);
		$this->redirect(array("email/confirmFinished"));
	}
	
	public function actionChangePassword() {
		$model = $this->getData_id_code( new User() );
		$passwordString = $model->genRandomCode();
		$model->password = $passwordString;
		$model->encode_password = true;
		$model->save(false);
		$this->render("txtChangePassword", array("password"=>$passwordString));
	}
	
	public function actionUnsubscribeWeeklyNews() {
		$model = $this->getData_id_code( new User() );
		$model->sendWeeklyEmail = false;
		$model->save(false, array("sendWeeklyEmail"));
		$this->render("txtUnsubscribe");
	}
	
	public function actionErrorSendEmail()
	{
		$model = $this->getData_id_code();
		$model->forceDelete = true;
		$model->delete();
		$this->render("emailDeleted");
	}
	
	public function getData_id_code( $userTable )
	{
		if (isset($_GET['id'])&&(isset($_GET['code'])))
		{
			$id = $_GET['id'];
			$code = $_GET['code'];

			$model = $userTable->findByPk($id);
			
			if ($model != null && $code == $model->getCodeForEmail())
			{
				return($model);
			} else
			{
				$this->redirect(array('email/confirmFailed'));	
			}
		} else 
		{
			$this->redirect(array("site/index"));
		}
	}
	
	public function actionTestEmail()
	{
		$message = new YiiMailMessage;
		
		$message->subject = 'Confirm your ZLOOP account, 08839125d!';
		$message->addTo('china.zhangchenzi@gmail.com');
		$message->from = array(Yii::app()->params['openEmail']=>"ZLOOP");
		
		$message->view = 'confirmEmail';
		$message->setBody('<center>How are you?</center>', 'text/html');
		
		Yii::app()->mail->send($message);
		
	}
	
	public function actionTestView()
	{
		$this->renderPartial("confirm");
	}
	
}
