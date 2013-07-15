<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
	echo "<table>";
	echo   "<tr length = 100%>";
	echo     "<td colspan=2>";
	echo     "</td>";
	echo   "</tr>";
	echo   "<tr>";
	echo     "<td colspan=2>";
	echo       $form->labelEx($model,'content');
	echo     "</td>";
	echo   "</tr>"; 
	echo     "<td colspan=2>";
	echo       $form->textArea($model,'content',array('rows'=>'3', 'cols'=>'107%')); 
	echo     "</td>";
	echo   "</tr>"; 
	echo   "<tr length = 100%>";
	echo     "<td>";
	echo       CHtml::submitButton('Leave a message');
	echo     "</td>";
	echo     "<td align='right'>";
	echo       $form->checkBox($model,'isprivate');
	echo       "&nbsp&nbsp";
	echo 	   $form->label($model,'isprivate');
	echo     "</td>";
	echo   "</tr>";
	echo "</table>";
		
	$this->endWidget();
?>

</div><!-- form -->
