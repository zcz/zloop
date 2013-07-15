<ul id="notifications" class="notifications-main">
	<li>Welcome to Zloop</li>
	<?php if(!Yii::app()->user->isGuest): ?>
		<li>|</li>
		<li class="notification-button" onclick="expand(this);"><a href="#">
		
<?php 
		if (count($messageList)+count($commentList)+count($replyList) == 0) {
			$color = '"#cccccc"';
		} else {
			$color = '"#ff0022"';
		}
		echo "<FONT COLOR=".$color.">Notifications</FONT></a>";
?>	
			<ul class="notifications-hide">
						
<?php 

if (count($messageList) !== 0)
{
	foreach ($messageList as $i => $data)
	{
		$url = $data->getReplyUrl();
		$text = $data->fromuser->getNameBold()." sent you a message.";
		$link = '<li><a href="'.$url.'" class="notification">'.$text.'</a></li>';
		echo $link;
	}
}

if (count($commentList) !== 0)
{
	foreach ($commentList as $i => $data)
	{
		$url = $data->getAnswerUrl();
		$text = $data->user->getNameBold()." asked you a question on the item ".$data->item->getShortTitleBold().".";
		$link = '<li><a href="'.$url.'" class="notification">'.$text.'</a></li>';
		echo $link;
	}
}

if (count($replyList) !== 0)
{
	foreach ($replyList as $i => $data)
	{
		$url = $data->getViewReplyUrl();
		$text = $data->item->user->getNameBold()." answered your question on the item ".$data->item->getShortTitleBold().".";
		$link = '<li><a href="'.$url.'" class="notification">'.$text.'</a></li>';
		echo $link;
	}
}
?>				
			</ul>
		</li>
	<?php endif; ?>
</ul>






