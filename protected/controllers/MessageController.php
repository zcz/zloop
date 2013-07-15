<?php

class MessageController extends ZLOOPController
{
	public function init() {
		//add this controller's title
		parent::init();
	}
	
	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
				//role control
				'replyControl + reply',
		);
	}
	
	public function filterReplyControl($filterChain) {
		if (!Yii::app()->user->isGuest && Yii::app()->user->id != Yii::app()->params['adminAccountNumber']) {
			if (isset($_GET['messageid'])) {
				$messageid = $_GET['messageid'];
				if ($messageid != 0) {	
					$message= Message::model()->findByPk($messageid);
					if ($message == null || $message->toid != Yii::app()->user->id) {
						$this->redirect(array("site/pageMissing"));
					}
				}
			} else {
				$this->redirect(array("site/pageMissing"));
			}
		}
		$filterChain->run();
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','showUserMessages'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('reply'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionShowUserMessages($userid)
	{
		$visiterid = Yii::app()->user->id; 
		if (!isset($visiterid) || $visiterid ==0) $visiterid = '0';
		
		$messageForm = new Message("create");
		$messageForm->parentid = 0;
		$messageForm->fromid=$visiterid;
		$messageForm->toid=$userid;
		
		//privacy control
		$private_control = " AND (isprivate=FALSE OR ( fromid=$visiterid OR toid=$visiterid ) ) ";
		
		$dataProvider=new CActiveDataProvider('Message', array(
		    'criteria'=>array(
		        'condition'=>"fromid=$userid OR toid=$userid ".$private_control,
		        'order'=>'create_time DESC',
			),
		    'pagination'=>array(
		        'pageSize'=>10,
			),
		));
			
		if(isset($_POST['Message']))
		{
			if (Yii::app()->user->isGuest)
			{
				$this->redirect(array("site/login"));
			}
			
			//get data from POST form
			$messageForm->attributes=$_POST['Message'];
			if($messageForm->validate() && $messageForm->save())
			{
				//for comment create log
				Yii::log("new message[ID:$messageForm->id], [toUser:$messageForm->toid]");
				$this->redirect(array('user/view', 'id'=>$userid));
			}
		}
		
		$this->renderPartial('/message/newMessage', array('model'=>$messageForm));
		
		//render the data part, all the comments
		$this->renderPartial('/message/listMessage',array('dataProvider'=>$dataProvider));
	}
	
	public function actionReply($messageid, $userid = 0)
	{
		$this->addToTitle("Reply Message");
		
		if ($userid == 0) {
			$userid = Yii::app()->user->id;
		}
		
		if ($messageid != 0) {
			$oldMessage = Message::model()->findByPk($messageid);
			$oldMessage->messageViewed();
			
			$messageForm = new Message("create");
			$messageForm->parentid = $messageid;
			$messageForm->fromid=$oldMessage->toid;
			$messageForm->toid=$oldMessage->fromid;
			$messageForm->isprivate = $oldMessage->isprivate;
		} else {
			$messageForm = new Message("create");
			$messageForm->parentid = 0;
			$messageForm->fromid = Yii::app()->user->id;
			$messageForm->toid = $userid;
		}
		
		if(isset($_POST['Message']))
		{
			//get data from POST form
			$messageForm->attributes=$_POST['Message'];
			if($messageForm->validate() && $messageForm->save())
			{
				//add to db in order to send email for new messages
				$messageForm->newMessageNewEmail();
				//for comment create log
				Yii::log("new message[ID:$messageForm->id], [toUser:$messageForm->toid]");
				$this->redirect(array('user/view', 'id'=>$userid));
			}
		}

		if ($messageid != 0) {
			$this->render('/message/replyMessage', array('messageForm'=>$messageForm, 'oldMessage'=>$oldMessage));
		} else {
			$this->redirect(array('user/view', 'id'=>$userid));
		}
	}

}
