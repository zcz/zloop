<?php
class EmailCommand extends CConsoleCommand
{
	private $nowTime;
	private $defaultInterval = 86400;
	private $anHour = 3600;
	private $aMinute = 50;
	private $aWeek = 0;
	private $total = 0;
	private $sentNotification = 0;
	private $notSentNotification = 0;
	private $emailMainContent;
	
	public function init() {
		$this->nowTime = time();
		$this->aWeek = $this->anHour * 24 * 7;
		return parent::init();
	}
	
/**
 * general email sending from db: email
 * defaul once per minute
 */
	public function actionSendEmailFromDB() {

		$emailServe = new EmailSending();
		while(true) {
			if ($this->aMinute + $this->nowTime <= time()) {
				Yii::log("stop sending email, times up " . $this->aMinute . " seconds ");
				break;
			}
			$email = Email::model()->find();
			if ($email !== null) {
				$email->delete();
				$emailServe->sendGeneralEmail($email->title, $email->body, $email->toemail);
			} else {
				break;
			}
		}	
	}
	
	
/**
 * ***************************************************************************************************************************************
 * weekly news part
 */
	
	public function actionSendWeeklyNewsSimple() {
		
		$emailServe = new EmailSending();
		
		Yii::log("Started email weekly's news");

		if ($this->checkNewItem() == false) {
			Yii::log("no new Items, stop sending weekly email");
			return;
		}
		
		$users = User::model()->findAll();
		$totalusers = count($users);
		foreach ($users as $user) {
			++$this->total;
			Yii::log("processing $this->total of $totalusers");
			if ($user->sendWeeklyEmail == true) {
				$content = $this->forEachOne($user);
				$emailServe->sendWeeklyNewsEmail($content, $user->email);
			} else {
				Yii::log("unsubscribed, ignore: " . $user->email);
			}
		}
		
		Yii::log("Weekly news done");
		
		//$emailServe->sendWeeklyNewsEmail($content, "chris19891128@gmail.com");
		//$emailServe->sendWeeklyNewsEmail($content, "shiyahua1990@gmail.com");
		//$emailServe->sendWeeklyNewsEmail($content, "china.zhangchenzi@gmail.com");
	}
	
	public function forEachOne($user) {
		
		$description = "";
		$description .= '<div style="
			color: #F60; font-size : 18px; font-family: \'Comic Sans MS\';">';
		$description .= "ZLOOP Updates, new items";
		$description .= '</div>';
		
		$content = "";
		if (isset($this->emailMainContent) == false) {
			$this->renderCategory($content, $index);
			$this->emailMainContent = $content;
		} else {
			$content = $this->emailMainContent;
		}
		
		$footer = $this->renderFooter( $user );
		
		return($description . $content . $footer);
	}
	
	
	public function renderFooter( $user ) {
		
		$unsubscribeLink = $user->getUnsubcribeUrl();
		
		
		$s  = "";
		$s .= "<p style=\"font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; margin-top: 5px; font-size: 10px; color: rgb(136, 136, 136);\">";
		$s .= "You are receiving this newsletter because you subscribed to it on ZLOOP.net, to unsbscribe ";
		$s .= "<a href=\"$unsubscribeLink\" target=\"_blank\">click here</a>.&nbsp;&nbsp;</p>";
		
		return($s);
	}
	
	public function checkNewItem() {
		$items = $this->getAllItemsInOneWeek();
		$result = count($items);
		Yii::log("the new items in email: " . $result);
		return(($result > 0));
	}
	
	public function renderCategory(&$content, &$index) {
	
		$content = "";
		$index = "";
		$items = $this->getAllItemsInOneWeek();
		
		//prepare first level category list
	
		foreach( Category::model()->getAllTreeById(0) as $cc ) {
			if ($cc->id > 0 && $cc->id<10 ){
	
				//$cTitle = $cc->title;
				$subContent = "";
				$number = $this->renderOneCategory($cc, $items, $subContent);
				if ($number > 0) {
					$content .= $subContent;
				}
			}
		}
	}
	
	public function renderOneCategory($category, $items, &$content) {
		$number = 0;
		$categoryUrl = $category->getUrl();
		$content = "";
		$content .= '<div style="
					float: left;
					width: 100%;
					border: 1px solid #C9E0ED;
					padding: 10px;
					background: #F0F5F8;
					margin : 10px 0px">';
		$content .= "<div>
			<a style='	
					text-decoration: none;
					font-size: 18px;
					font-weight: bold;
					color: #06C;
					font-family: Trebuchet,\"Trebuchet MS\";' href=$categoryUrl> $category->title </a></div>";
		foreach ($items as $item) {
			if ($item->categoryid == $category->id || $item->category->parentid== $category->id) {
				++$number;
				$content .= $this->renderOneItem($item);
			}
		}
		$content .= '<div style="clear: both;"></div>';
		$content .= "</div>";
		return($number);
	}
	
	public function renderOneItem( $item ) {
		//more restrict need to be added to the title and description
		$s  = "";
		$s .= '<div style="
		float: left;
		width: 132px;
		max-height: 175px;
		min-height: 175px;
		border: hidden 1px gray;
		text-align: center;
		margin: 5px 8px;
		overflow : hidden;
		border: 2px dashed #A2CD5A;"
		>';
		$s .= 	'<div style="float:letf">' . $item->getFirstPicLinkWithCss() . '</div>';
		$s .= 	'<div style="margin-top: 3px;
				color: #F60;
				font-size: 14px;
				font-family: \'Comic Sans MS\';">' . $item->getPrice() . '</div>';
		$s .= 	'<div style="float:center;">' . $item->getTitleLinkWithCss() . '</div>';
		$s .= 	'<div class = "clearAllDiv"></div>';
		$s .= '</div>';
		return ($s);
	}
	
	public function getAllItemsInOneWeek() {
		$aWeek = 60 * 60 * 24 * 7;
		$keyWord = new SearchKeysForm;
		$keyWord->timeStart = time() - $aWeek;
		$keyWord->timeStop = time();
		$items = Goods::model()->searchItems($keyWord);
		return($items);
	}
	
	
/**
******************************************************************************************************************************************
 * notification part
 */	
	/*
	public function actionSendEveryDayNotification() {
		
		Yii::log("Started email notifications");
		
		$users = User::model()->findAll();
		foreach ($users as $user) {
			++$this->total;
			$this->processUser($user);
		}	
		
		$this->notSentNotification = $this->total - $this->sentNotification;
		Yii::log("Sending notifications finished, report:");
		Yii::log("Total                 : " . $this->total);
		Yii::log("Send notification     : " . $this->sentNotification);
		Yii::log("Not Send notification : " . $this->notSentNotification);
	}*/
	
	/* used for testing
	public function actionProcessUserWithUid($uid) {

		$user = User::model()->findByPk($uid);
		$this->processUser($user);
	}*/
		
	/*
	public function processUser($user) {
		
		$uid = $user->id;
		if (($user->ifNotify == 1) && ($user->nextNotify<$this->nowTime)) {
			//it is time to send notification, default once a day
			if ($user->intervalNotify <= 0) $user->intervalNotify = $this->defaultInterval;
			if ($user->nextNotify <= 0) $user->nextNotify = $this->nowTime - $this->anHour;
			while($user->nextNotify <= $this->nowTime) $user->nextNotify += $user->intervalNotify;
			$user->save(false);
		} else {
			//ifNotify = false, no email notification, not continue
			//echo "nothing\n";
			return;
		}
		
		$notice = $this->getNotifications($uid);
		if ($notice != null) {
			//there is notice for user, so send email 
			$this->emailNotifications($user, $notice);
		}
	}
	
	public function getNotifications($uid) {
		$notice = new Notification();
		$notice->setUID($uid);
		$notice->init();
		if ($notice->hasNotification()) {
			//$messages = $notice->getAllNotifications();
			//print_r($messages);
			return($notice);
		} else {
			return(null);
		}
	}
	
	public function emailNotifications($user, $notice) {
		++$this->sentNotification;
		//Yii::log("Send notification to user[ID:$user->id]: " . $user->email);
		
		$emailServe = new EmailSending();
		$emailServe->sendEmailNotification($user, $notice);
	}
	*/
}