<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lastview'); ?>
		<?php echo $form->textField($model,'lastview'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lastcomment'); ?>
		<?php echo $form->textField($model,'lastcomment'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lastreply'); ?>
		<?php echo $form->textField($model,'lastreply'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'viewnum'); ?>
		<?php echo $form->textField($model,'viewnum'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'itemid'); ?>
		<?php echo $form->textField($model,'itemid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->