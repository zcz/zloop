<?php

/**
 * This is a model for email sending
 * Use the smtp on zloop.net
 */
class EmailSending extends CComponent
{
	/**
	 * Send email to user for email confirmation
	 */
	public function sendEmailConfirm($model)
	{
		$message = new YiiMailMessage;
		
		$message->subject = 'Activate your ZLOOP account, '.$model->username.'!';
		$message->addTo($model->email);
		$message->from = array(Yii::app()->params['openEmail']=>"ZLOOP");
		
		$message->view = 'confirmEmail';
		$message->setBody(array('model'=>$model), 'text/html');
		
		Yii::app()->mail->send($message);
		
		Yii::log("EMAIL-TO: ".$model->email . ' for confirm user email');
	}

	/**
	* Send email to user 
	* for notification of new messages
	*/
	public function sendEmailNotification($user, $notice)
	{
		$message = new YiiMailMessage;
	
		$message->subject = 'Notifications from ZLOOP';
		$message->addTo($user->email);
		$message->from = array(Yii::app()->params['openEmail']=>"ZLOOP");
	
		$message->view = 'notificationEmail';
		$message->setBody(array('model'=>$user, 'notice'=>$notice), 'text/html');
	
		Yii::app()->mail->send($message);
	
		Yii::log("EMAIL-TO: [ID:$user->id] $user->email for notification reminder");
	}
	
	/**
	 * The model is ContactForm
	 * This function send email for feedback
	 */
	public function sendFeedbackEmail($model)
	{
		$userID = Yii::app()->user->id;
		
		$message = new YiiMailMessage;
		
		$message->subject = "Feedback [name: $model->name] [subject: $model->subject]";
		$message->addTo(Yii::app()->params['adminEmail']);
		$message->from = array(Yii::app()->params['openEmail']=>"ZLOOP");
		
		$emailBody = "Subject: $model->subject \n";
		$emailBody .=  "From: [ID:$userID] [name: $model->name] $model->email \nBody: \n\n$model->body";
		
		$message->setBody($emailBody);
		Yii::app()->mail->send($message);
		
		Yii::log("Feedback from: ".$model->email);
	}
	
	public function sendWeeklyNewsEmail($content, $receiverEmail) {
	
		$this->sendGeneralEmail("Zloop: this week's new items", $content, $receiverEmail);
	
	}
	
	public function sendForgetPasswordEmail( $email ) {
		$user = User::model()->findByEmail( $email );
		if ( $user == null ) return;
		
		$url = $user->getForgetPasswordUrl();
		
		$toPerson = $user->email;
		$title = "ZLOOP -- Forget Password";
		$body = Yii::app()->controller->renderPartial("/email/partialForgetPassword", array('user'=>$user), true);
		$email = new Email("create");
		$email->toemail = $toPerson;
		$email->title = $title;
		$email->body = $body;
		$email->save();
	}
	
	public function sendAccountInfoEmail( $user, $password ) {
		$toPerson = $user->email;
		$title = "ZLOOP -- Your Account Info";
		$body = Yii::app()->controller->renderPartial("/email/partialAccountInfo", array('user'=>$user, 'password'=>$password), true);
		$email = new Email("create");
		$email->toemail = $toPerson;
		$email->title = $title;
		$email->body = $body;
		$email->save();
	}
	
	public function sendGeneralEmail(
		$title, 
		$body, 
		$receiverEmail, 
		$viewFile = "generalEmail", 
		$sender = null ) {
		
		if ($sender == null)
		{
			$sender = array(Yii::app()->params['openEmail']=>"ZLOOP");
		}
		
		$message = new YiiMailMessage;
		
		$message->subject = $title;
		$message->addTo($receiverEmail);
		$message->from = $sender;
		
		$message->view = $viewFile;
		
		$message->setBody(array('content'=>$body), 'text/html');
		
		Yii::app()->mail->send($message);
		
		Yii::log("EMAIL-TO: $receiverEmail title: $title");
	}
}