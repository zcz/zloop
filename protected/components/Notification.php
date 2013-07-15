<?php

/**
 * 
 * show notifictions, like new comments and new reply
 * @author zcz
 *
 */

class Notification extends CWidget
{
	private $hasNotifications = false;
	private $uid = null;
	public $commentList;
	public $messageList;
	public $replyList;
	
	public function setUID($id) {
		$this->uid = $id;
	}
	
	public function getAllNotifications() {
		return(array_merge($this->commentList, $this->messageList, $this->replyList));
	}
	
    public function init()
    {
        if ($this->uid == null) { 
        	$this->uid = Yii::app()->user->id;
        }
        $this->commentList = array();
        $this->replyList = array();
        $this->messageList = array();
        parent::init();
    }
    
    private function findContent()
    {	
    	$this->commentList = Item::model()->notification($this->uid);
    	$this->replyList = Comment::model()->notification($this->uid);
    	$this->messageList = Message::model()->notification($this->uid);
    }   

    public function hasNotification()
    {
    	$this->findContent();
    	if (count($this->commentList) != 0) return true;
    	if (count($this->replyList) != 0) return true;
    	if (count($this->messageList) != 0) return true;
    	return false;
    } 
    
    protected function renderContent()
    {
    	if ($this->uid != null) 
    	{
    		$this->findContent();
    	}
    	return $this->render('notificationList',
    		array(
    			"commentList"=>$this->commentList,
        		"replyList"=>$this->replyList,
    			"messageList"=>$this->messageList,
    		)
    	);
    }
    
    public function run()
    {
		$this->renderContent();    	
    }
}