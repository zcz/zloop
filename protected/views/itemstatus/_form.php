<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'itemstatus-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lastview'); ?>
		<?php echo $form->textField($model,'lastview'); ?>
		<?php echo $form->error($model,'lastview'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastcomment'); ?>
		<?php echo $form->textField($model,'lastcomment'); ?>
		<?php echo $form->error($model,'lastcomment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastreply'); ?>
		<?php echo $form->textField($model,'lastreply'); ?>
		<?php echo $form->error($model,'lastreply'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'viewnum'); ?>
		<?php echo $form->textField($model,'viewnum'); ?>
		<?php echo $form->error($model,'viewnum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'itemid'); ?>
		<?php echo $form->textField($model,'itemid'); ?>
		<?php echo $form->error($model,'itemid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->