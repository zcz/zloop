<div class="view">

<?php
	//build the message title
	$title = $data->fromuser->getNameLink()."'s message to ";
	$title .= $data->touser->getNameLink()." (".date('Y-m-d',$data->create_time).")";
	if ($data->isprivate)
	{
		$title .= " (private) ";
	}
	
	//only the message receiver can reply that message
	if ($data->toid == Yii::app()->user->id)
	{
		$reply_link = $data->getReplyLink();
	} else
	{
		$reply_link = "";
	}
	
	echo "<table><tr>";
	echo   "<td>";
	echo     '<span style="color: rgb(153, 153, 153);">'.$title.'</span>';
	echo   "</td>";
	echo   "<td align='right'>";
	echo     $reply_link;
	echo   "</td>";
	echo "</tr>";
	echo "<tr><td>";
	echo CHtml::encode($data->content);
	echo "</td></tr>";
	echo "</table>";

?>	

</div>
