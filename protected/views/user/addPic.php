<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'addPic-user',
	'enableAjaxValidation'=>false,
	"action"=>Yii::app()->createAbsoluteUrl("/user/editPic", array("id"=>$user->id)),
	'htmlOptions'=>array('enctype'=>'multipart/form-data',)
)); 
?>

<?php
	$pic = new Pic('create');
	
	$picc = $user->profilePic;
	if ($picc != null)
	{
		echo CHtml::image($picc->getUrl(), "", array('height'=>'153px'));
	} else {
		echo CHtml::image(Pic::model()->getUserLargePic($user), "");
	}
	echo 	"<div style='height:3px;'></div>";
	echo 	$form->error($pic,"data");
	echo 	$form->fileField($pic,"data");
	
	echo 	CHtml::submitButton('update', array("name"=>"addOnePic",));
?>

<?php $this->endWidget(); ?>