<?php 

$content = $this->renderPartial("/message/viewOneMessage_Beauty", array('data'=>$oldMessage), true);
$content .= $this->renderPartial('/message/newMessage', array('model'=>$messageForm), true);

$this->widget("DisplayBox",
array(
		'title' => "Reply to " . $messageForm->touser->username,
		'content' => $content
));

?>