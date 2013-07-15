	<?php
		if (isset($model) == false) 
			$model=new LoginForm; 
		
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'login-form',
			'enableClientValidation'=>false,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
				),
			)
		); ?>
	
		Email: <?php echo $form->textField($model,'username'); ?>
		Password: <?php echo $form->passwordField($model,'password'); ?>
		<?php echo CHtml::submitButton('Login'); ?>
		
	<?php $this->endWidget(); ?>