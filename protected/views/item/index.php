<?php 

$content = "";

$content .= $this->renderPartial('/item/_f_searchkeys', array('model'=>$model), true);

$content .= $this->renderPartial("/item/_searchResult", array("dataProvider"=>$dataProvider), true);

$content .= '<div class="clearAllDiv"></div>';

$this->widget("DisplayBox", array(
	'title' => "List Items: ",
	'content' => $content,
	'withSpaceAround' => false,
	'withSpaceTopBottom' => false,
));

?>

