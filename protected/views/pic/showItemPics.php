<?php
	$content = "";

	if ($item->ifPicFull()){
		$content .= "<font size='3' color='gray'>Your pictures are full.<br>";
		$content .= "Please remove some.</font><br>";
	}
	
	if ($item->pictures == null || count($item->pictures) == 0)
	{
		$content .= "<font size='3' color='gray'>";
		$content .= "Still no pictures ~ <br>";
		$content .= "You can: <br>";
		$content .= "1. upload local file; <br> ";
		$content .= "2. choose from google.";
		$content .= "</font>";
	} else {
		foreach ($item->pictures as $i=>$picc) {
			$content .= CHtml::image($picc->getUrl(), "", array('height'=>'80'));
			$content .= "<br>";
			$content .= CHtml::link("delete", array("", 'id'=>$item->id, "deleteId"=>$picc->id));
			$content .= "<br><br><br>";
		}
	}	
	
	$picCount = 0;
	
	if ($item->pictures != null ){
		$picCount = count($item->pictures);
	}
	
	$picText = "My Pictures ($picCount): ";
	
	if ($picCount != 0) {
		$picText = "<span style=\"color: rgb(255, 102, 0);\">$picText</span>";
	}
	$this->widget("DisplayBox", array(
			'title' => $picText,
			'content' => $content,
			'withSpaceAround' => false,
	));
?>