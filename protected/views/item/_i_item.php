<?php 
	$widget = $this->createWidget("ItemDisplayWidget", array(), false);
	$s = '<div class = "itemListContainer">';
	$s .= $widget->renderItem_div($data);
	$s .= "</div>";	
	echo $s;
?>