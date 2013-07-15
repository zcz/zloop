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
		<?php echo $form->label($model,'parentid'); ?>
		<?php echo $form->textField($model,'parentid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'itemid'); ?>
		<?php echo $form->textField($model,'itemid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fromuserid'); ?>
		<?php echo $form->textField($model,'fromuserid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'touserid'); ?>
		<?php echo $form->textField($model,'touserid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'meetingtime'); ?>
		<?php echo $form->textField($model,'meetingtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'meetingaddress'); ?>
		<?php echo $form->textArea($model,'meetingaddress',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reply'); ?>
		<?php echo $form->textArea($model,'reply',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'confirmed'); ?>
		<?php echo $form->textField($model,'confirmed'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->