<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>false,
	'action'=>Yii::app()->createAbsoluteUrl("/comment/create", array("id"=>$model->itemid)),
)); ?>

<?php

	if (Yii::app()->user->isGuest)
		$disableForm = true;
	else
		$disableForm = false;
	
	echo "<div class=\"text-area\">";
	echo $form->textArea($model,'content',array('class'=>"message-box-editor", 'disabled'=>$disableForm));
	echo "</div>";
	echo "<div>";

	if ($disableForm) {
		echo '<p style="color:#FF0000">Please login to ask questions</p>';
	} else {
		echo "<div>";
		echo $form->checkBox($model,'isprivate', array()); 
		echo "<label>Private </label>";
		echo CHtml::submitButton('Submit', array('class'=>"leave-message-button"));
		echo "</div>";
	}

	echo "</div>";
	$this->endWidget();
?>

</div><!-- form -->
