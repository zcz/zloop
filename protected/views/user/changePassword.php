<div class="enlarge_font_size" style="width:680px; margin-right: auto; margin-left: auto;">
<?php 
	
	if ($model->passwordChanged) {
		$moreLink = "<span style=''>Password Changed Successfully</span>";	
	} else {
		$moreLink = "";
	}

	$this->widget("DisplayBox",
	array(
		'title' => "Change Password: ",
		'moreLink' => $moreLink,
		'content' => $this->renderPartial('_f_changePassword', array('model'=>$model), true),
		'withSpaceAround' => false,
	));

?>
</div>