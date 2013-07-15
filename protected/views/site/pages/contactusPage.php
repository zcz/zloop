<div style="margin:20px;">
<?php if(Yii::app()->user->hasFlash('contact')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<div style="

float:left;
margin-right:20px;
padding-right: 20px;

border-right-style:dotted;
border-right-width:2px;

">

	<div style='
	background-image: none;
	color: #36781B;
	font-size: 20px;
	margin-bottom: 3px;'
	>Email us</div>
	
	<div class='cleanAllDiv'></div>
	
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'contact-form',
		'enableClientValidation'=>false,
		'clientOptions'=>array(
			'validateOnSubmit'=>false,
		),
	)); ?>
		<?php echo $form->errorSummary($model); ?>
				<div class="row">
			<?php echo $form->labelEx($model,'name').'<br>'; ?>
			<?php echo $form->textField($model,'name'); ?>
			<?php echo $form->error($model,'name'); ?>
				</div>
				<div class="row">
			<?php echo $form->labelEx($model,'email').'<br>'; ?>
			<?php echo $form->textField($model,'email'); ?>
			<?php echo $form->error($model,'email'); ?>
				</div>
				<div class="row">
			<?php echo $form->labelEx($model,'subject').'<br>'; ?>
			<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
			<?php echo $form->error($model,'subject'); ?>
				</div>
				<div class="row">
			<?php echo $form->labelEx($model,'body').'<br>'; ?>
			<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'body'); ?>
				</div>
				<div class="row buttons">
			<?php echo CHtml::submitButton('Send A Email'); ?>
				</div>
	<?php $this->endWidget(); ?>
	
	</div>
</div>

<div style="float:left">

<div 
style="

font-size: 18px;
text-align: left;
width : 400px;
margin-bottom: 20px;
">
For ongoing information about zloop, please read our 
<a 
style="
text-decoration:none;
color: #0084B4;
font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
 
" href=<?php echo $this->createUrl("about"); ?>>About Us</a>. 
Also, feel free to contact us with service questions, bug reporting, or to join us.
</div>

	<div style='
	background-image: none;
	color: #36781B;
	font-size: 20px;
	margin-bottom: 3px;'
	>Phone Numbers:</div>
	
	<div style='font-size: 16px;'>
	<ul>
	  <li> (+852) 64457232</li>
	  <li> (+852) 51358275</li>
	</ul>
	
	</div>

	<div style='
	margin-top: 20px;
	background-image: none;
	color: #36781B;
	font-size: 20px;
	margin-bottom: 3px;'
	>Emails: </div>
	
	<div style='font-size: 16px;'>
	<ul>
	  <li> 08820985d@connect.polyu.hk</li>
	  <li> 08839125d@connect.polyu.hk</li>
	</ul>
	</div>


</div>


<!-- form -->
<?php endif; ?>