<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'attach-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'itemid'); ?>
		<?php echo $form->textField($model,'itemid'); ?>
		<?php echo $form->error($model,'itemid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_modified'); ?>
		<?php echo $form->textField($model,'last_modified'); ?>
		<?php echo $form->error($model,'last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data'); ?>
		<?php echo $form->textField($model,'data'); ?>
		<?php echo $form->error($model,'data'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'icon'); ?>
		<?php echo $form->textField($model,'icon'); ?>
		<?php echo $form->error($model,'icon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'story'); ?>
		<?php echo $form->textField($model,'story',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'story'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deleted'); ?>
		<?php echo $form->textField($model,'deleted'); ?>
		<?php echo $form->error($model,'deleted'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->