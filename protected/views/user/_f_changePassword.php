<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'changePassword_user',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<?php	

	echo "<span style='color:red'>" . $form->errorSummary($model) . "</span>";	
	
	echo "<table border='0'>";
	echo 	"<tr>";
	echo 		"<td>";
	echo 			CHtml::activeLabel($model,'oldPassword');
	echo 		"</td>";
	echo 		"<td>";
	echo 			$form->passwordField($model, "oldPassword");
	echo 		"</td>";
	echo 	"</tr>";
	echo 	"<tr>";
	echo 		"<td>";
	echo 			CHtml::activeLabel($model,'password');
	echo 		"</td>";
	echo 		"<td>";
	echo 			$form->passwordField($model,"password");
	echo 		"</td>";
	echo 	"</tr>";
	echo 	"<tr>";
	echo 		"<td>";
	echo 			CHtml::activeLabel($model,'password_repeat');
	echo 		"</td>";
	echo 		"<td>";
	echo 			$form->passwordField($model,"password_repeat");
	echo 		"</td>";
	echo 	"</tr>";
	echo 	"<tr>";
	echo 		"<td>";
	echo 			CHtml::submitButton('Change', array("name"=>"finishPic"));
	echo 		"</td>";
	echo 	"</tr>";
	echo "</table>";
?>

<?php $this->endWidget(); ?>