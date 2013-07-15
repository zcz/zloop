<?php 

$this->widget("DisplayBox",
array(
	'title' => "Contact Us",
	'content' => $this->renderPartial("/site/pages/contactusPage", array('model'=>$model), true),
	'withSpaceAround' => false,
	'withSpaceTopBottom' => false,
));

?>