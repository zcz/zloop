<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/login.css" />
<div class="signin-box">

<div class="facebook-log-in-box">		
	<span class="facebook-or-text"> or </span>
	<a href="<?php echo Yii::app()->createAbsoluteUrl("/facebook/login");?>">
		<img class="facebook-log-in-box-img" src="/images/decoration/facebook_connect_button.png" />
	</a>
</div>


	<div class="sign-in-sign">Sign in</div>
	
	<div class="clearAllDiv"></div>
	
	<div>
	<?php
		if (isset($model) == false) 
			$model=new LoginForm; 
		
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'login-form',
			'enableClientValidation'=>false,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
				),
			'action'=>array('site/login'),
			)
		); ?>
	
	<label>
		<strong class="email-label">Email</strong>
		<?php echo $form->textField($model,'username'); ?>
	</label>
	<label>
		<strong class="password-label">Password</strong>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php 
			echo '<div style= "
				padding-top: 10px; 
				color: red; 
				text-align: left;
				font-family: \'Comic Sans MS\'; "> '; 
			echo $form->error($model, 'username');
			echo $form->error($model, 'password');
			echo '</div>'; 
		?>
		
	</label>		

	<?php echo CHtml::submitButton('Login'); ?>
	<label class="remember">
		<?php echo $form->checkBox($model,'rememberMe'); ?>	
		<strong class="remember-label">Remember me next time</strong>
	</label>
		
	<?php $this->endWidget(); ?>
	
	<?php 
		echo CHtml::link("Can't access your account?", array("site/forgetPassword"), array("style"=>'text-decoration: none;'));
	?>
	</div><!-- form -->
</div>
