<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'appointment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'meetingtime'); ?>
		<?php echo $form->textField($model,'meetingtime'); ?>
		<?php echo $form->error($model,'meetingtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meetingaddress'); ?>
		<?php echo $form->textField($model,'meetingaddress'); ?>
		<?php echo $form->error($model,'meetingaddress'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->