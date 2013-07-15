<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php echo $form->textArea($model,'reply',array('class'=>"message-box-editor")); ?>
		<?php echo $form->error($model,'reply'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Answer'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
