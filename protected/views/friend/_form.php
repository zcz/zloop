<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'friend-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fromid'); ?>
		<?php echo $form->textField($model,'fromid'); ?>
		<?php echo $form->error($model,'fromid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'toid'); ?>
		<?php echo $form->textField($model,'toid'); ?>
		<?php echo $form->error($model,'toid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->