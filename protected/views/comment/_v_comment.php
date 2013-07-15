<div class="enlarge_font_size">

<div class="view">

	<?php
		$title = $data->user->getNameLink();
		$title .= "<span style='font-size:14px;'> asked at (".date('Y-m-d h:m:s',$data->create_time) . ")</span>";
		if ($data->isprivate)
		{
			$title .= " (private) ";
		}
		if ($data->item->userid == Yii::app()->user->id)
		{
			$reply_link = $data->getAnswerLink();
			$ignore_link = $data->getIgnoreLink();
			$reply_link .= " | " . $ignore_link;
		} else 
		{
			$reply_link = '';
		}
		
		echo "<table><tr>";
		echo   "<td>";
		echo     '<span style="color: rgb(153, 153, 153);">'.$title.'</span>';
		echo   "</td>";
		echo   "<td align='right'>";
		echo     $reply_link;
		echo   "</td>";
		echo "</tr></table>";
	?>	
	<?php echo "<b>Question</b>: ".CHtml::encode($data->content);?>

	<?php
		if ($data->reply_time!=0)
		{
			echo "<br/>";
			echo "<b>Answer</b>: ".CHtml::encode($data->reply); 
		}
	?>	
	
</div>

</div>