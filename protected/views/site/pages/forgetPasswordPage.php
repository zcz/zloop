<?php if(Yii::app()->user->hasFlash('forgetPassword')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('forgetPassword'); ?>
</div>

<?php else: ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'forgetPassword-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div style="width:100%">
	<div style="width:25%; float: left">

		
		<div class="row">
			<div class="row">
				<?php echo $form->labelEx($model,'email'); ?>
			</div>
			<?php echo $form->textField($model,'email'); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
		
		<div class="row">
			<div class="row">
				<?php echo $form->labelEx($model,'verifyCode'); ?>
			</div>
			<?php echo $form->textField($model,'verifyCode'); ?>
			<?php echo $form->error($model,'verifyCode'); ?>
		</div>
	
	</div>
	<div style="width:75%; float: right; margin-top: 20px;">

		<?php if(CCaptcha::checkRequirements()): ?>
		<div class="row">
			
			<div>
			<?php $this->widget('CCaptcha'); ?>
			
			</div>
			<div class="hint">Please enter the letters as they are shown in the image above.
			<br/>Letters are not case-sensitive.</div>
			
		</div>
		<?php endif; ?>

	</div>

	<div class="clearAllDiv"></div>
</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>