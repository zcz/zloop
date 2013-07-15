<?php if(Yii::app()->user->hasFlash('actionDone')): ?>
<div class="flash-success" style="margin-bottom: -13px;">
	<?php echo Yii::app()->user->getFlash('actionDone'); ?>
</div>
<?php endif; ?>

<div class="enlarge_font_size" style="width:200px; float:left; margin-left: 20px; margin-right: auto;"> 
	
	<?php 
		if ($model->profilePic != null) {
			$deleteId = $model->profilePic->id;
		} else {
			$deleteId = -1;
		}
		$this->widget("DisplayBox",
		array(
			'title' => "Edit Picture:",
			'moreLink'=> CHtml::link("delete", array("editPic", 'id'=>$model->id, "deleteId"=>$deleteId)),
			'content' => $this->renderPartial('addPic', array('user'=>$model), true),
			'withSpaceAround' => false,
		));
	?>
</div>



<div class="enlarge_font_size" style="width:680px; float:right; margin-right: 20px; margin-left: auto;">
<?php 
 	$moreLinkString = "";
/*	$moreLinkString .= CHtml::link("change password", 
		array("changePassword", 'id'=>$model->id,), 
		array('onclick'=>'OpenPopupTerms(this.href, "Service Terms"); return false',)); */
 	$moreLinkString .= CHtml::link("change password", array("changePassword", 'id'=>$model->id,) );
	
	$this->widget("DisplayBox",
	array(
		'title' => "Edit my profile:",
		'moreLink' => $moreLinkString,
		'content' => $this->renderPartial('_form', array('model'=>$model), true),
		'withSpaceAround' => false,
	));
?>
</div>


<script type="text/javascript" language="javascript">
<!--
function OpenPopupTerms (c, title) {

	var width  = 400;
	var height = 200;
	var left   = (screen.width  - width)/2;
	var top    = (screen.height - height)/2;
	var params = 'width='+width+', height='+height;
	params += ', top='+top+', left='+left;
	params += ', directories=no';
	params += ', location=no';
	params += ', menubar=no';
	params += ', resizable=no';
	params += ', scrollbars=no';
	params += ', status=no';
	params += ', toolbar=no';
	newwin=window.open(c,title, params);
	if (window.focus) {newwin.focus()}
	return false;
}
//--> </script> 
