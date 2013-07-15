<?php 

$this->widget("DisplayBox",
array(
	'title' => "To reset your password, please enter the email address you use to sign in Zloop",
	'content' => $this->renderPartial("/site/pages/forgetPasswordPage", array('model'=>$model), true),
	'withSpaceAround' => false,
	'withSpaceTopBottom' => false,
));

?>