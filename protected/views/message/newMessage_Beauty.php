<div class="tab-bar">
	<div class="message-box-title">Messages</div>
</div>

<div class="message-box">

<?php 
if (!isset($model)) 
{
	$model = new Message("create");
}
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-form',
	'enableAjaxValidation'=>false,
	'action'=>Yii::app()->createAbsoluteUrl(
		"/message/reply", array("messageid"=>0, 'userid'=>$touserid)),
)); ?>

	<div class="text-area">
		<?php echo $form->textArea($model,'content',array('class'=>"message-box-editor")); ?>
	</div>
	<div class="message-button">
		<div class="message-sub-button">
			<?php echo $form->checkBox($model,'isprivate', array()); ?>
			<label for="Message_isprivate">Private</label>
			<?php echo CHtml::submitButton('Leave a message', array('class'=>"leave-message-button"));?>
		</div>
	</div>
	
<?php		
	$this->endWidget();
?>

</div> <!-- form -->




