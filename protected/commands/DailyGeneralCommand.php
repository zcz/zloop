<?php

/**
 * this daily program will be run once a day
 * do some maintainance things: 
 * 1. work with selling item's expire action (email notification and other)
 */
class DailyGeneralCommand extends CConsoleCommand
{
	private $nowTime;
	
	public function init() {
		// current time
		$this->nowTime = time();
		return parent::init();
	}	
	
	/**
	 * the action used to expire items
	 */
	public function actionExpireItem() {
	
		Yii::log("Started clean item daily work");
		
		$this->cleanItem();
		$this->expireItem();
				
		Yii::log("finish clean item daily work");
	}	
	
	public function cleanItem() {

		Yii::log("clean item:");
		
		$keyWord = new SearchKeysForm;
		$keyWord->conditionid = Yii::app()->params['conditionClean'];
		$items = Goods::model()->searchItems($keyWord);
		
		foreach ($items as $item) {
			//Yii::log("exam item: " . $item->id);
			//remove item if modified too long ago
			if ($item->last_modified + Yii::app()->params['removeAfterTime'] <= $this->nowTime ) {
				Yii::log("item removed by system, uid:". $item->userid ." id:" . $item->id . "; title : " . $item->title);
				$item->delete();
			}
		}
	}
	
	public function expireItem() {
		
		Yii::log("expire item:");
		
		$keyWord = new SearchKeysForm;
		$items = Goods::model()->searchItems($keyWord);
		
		foreach ($items as $item) {
			//Yii::log("timeNow: " .$this->nowTime. "working on Item: " . $item->id . " expire_time: " . $item->expire_time . "  next five days: ". ($this->nowTime + Yii::app()->params['expireNotificationBefore']));
			//expire an item
			if ($item->expire_time <= $this->nowTime) {
				$item->conditionbackup = $item->conditionid;
				$item->conditionid = Yii::app()->params['conditionExpired'];
				$item->save(false, array("conditionid", "conditionbackup", "last_modified"));
				Yii::log("item expired by system, uid:". $item->userid ." id:" . $item->id . "; title : " . $item->title);
				continue;
			}
			//send item expiration notification
			if ($item->expire_time <= $this->nowTime + Yii::app()->params['expireNotificationBefore']) {
				if ($item->expire_time != $item->expire_email_flag_time) {
					$item->expire_email_flag_time = $item->expire_time;
					$item->save(false, "expire_email_flag_time");
					$this->newItemExpireNotification( $item );
					Yii::log("expire notification sent by system, uid:". $item->userid ." id:" . $item->id . "; title : " . $item->title);
				}
			}
		}
	}
	
	public function newItemExpireNotification( $item ) {
		$toPerson = $item->user->email;
		$title = "ZLOOP -- Expire Notification [Item: " . $item->title . "]";
		$body = $this->renderConsole("partialItemExpireNotification", array('item'=>$item));
		$email = new Email("create");
		$email->toemail = $toPerson;
		$email->title = $title;
		$email->body = $body;
		$email->save();
	}
	
	private function renderConsole($template, array $data = array()){
		$path = Yii::getPathOfAlias('application.views.email').'/'.$template.'.php';
		if(!file_exists($path)) throw new Exception('Template '.$path.' does not exist.');
		return $this->renderFile($path, $data, true);
	}
}

