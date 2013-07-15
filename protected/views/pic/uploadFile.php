<?php 
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'addPic-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),	
	)); 
	echo $form->error($pic, "data");
	echo "<b>File:</b> " . $form->fileField($pic,"data");
	echo "<b>Description:</b> " . $form->textField($pic,"story");
	echo CHtml::submitButton('upload', array("name"=>"addOnePic", "style"=>"float:right"));
	$this->endWidget(); 
?>