<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>

<div>
	<table border = "0">
	  <tr>
	    <td width="200px"><span class="form-label">Your email address<span style="color:red;">*</span> :</span></td>
	    <td><?php 
	    	if ($model->isNewRecord)
		    	echo $form->textField($model,'email',array('maxlength'=>255)); 
			else
				echo CHtml::encode($model->email);
	    	?></td>
	  </tr>
	  <tr >  
	  	<td><span class="form-label">Username<span style="color:red;">*</span> :</span></td>
	    <td><?php echo $form->textField($model,'username',array('maxlength'=>255)); ?></td>
	  </tr >
	  <?php 
	  if ($model->isNewRecord)
	  {
		echo   "<tr>";  
		echo     '<td><span class="form-label">Choose a password<span style="color:red;">*</span> :</span></td>';
		echo	 '<td>';	 
		echo 	   $form->passwordField($model,'password',array('maxlength'=>255));
		echo     '</td>';
		echo   '</tr>';
		echo   '<tr>';  
		echo     '<td><span class="form-label">Re-enter password<span style="color:red;">*</span> :</span></td>';
		echo     '<td>';
		echo       $form->passwordField($model,'password_repeat',array('maxlength'=>255));
		echo     '</td>';
		echo   '</tr>'; 
	  }?>  
	  <tr>
	  	<td><span class="form-label">Phone number:</span></td>
	    <td><?php echo $form->textField($model,'phone',array('maxlength'=>255)); ?></td>
	  </tr>
	  <tr>  
	  	<td><span class="form-label">Address:</span></td>
	    <td><?php 
	    	if ($model->isNewRecord) {
	    		$model->address = "Room****, Student Halls Of Residence, PolyU";
	    	}
	    	echo $form->textField($model,'address',array('maxlength'=>255)); ?></td>
	  </tr>
	  
  		<?php 
			if ($model->isNewRecord)
			{
				echo '<tr>';  
  				echo   '<td colspan=2 style="color:black">';
				$terms = '<a href='.$this->createUrl("site/serviceTerms").' onclick=\'OpenPopupTerms(this.href, "Service Terms"); return false\'>Service Terms</a>';
  				$privacy = '<a href='.$this->createUrl("site/privacyPolicy").' onclick=\'OpenPopupTerms(this.href, "Privacy Policy"); return false\'>Privacy Policy</a>';
				echo 'I agree: ';
				echo $terms;
				echo ' and ';
				echo $privacy;
				echo '. ';
				echo $form->checkBox($model,'iagree');
				echo '</td>';
  				echo '</tr>';
			} else {
				//used for setting notification sending property
				/*
				echo '<tr>';
				echo   '<td colspan=2 style="color:black">';
				echo 'Send me notifications of messages and comments through email: ';
				echo $form->checkBox($model,'ifNotify');
				echo '</td>';
				echo '</tr>';
				*/
				
				//used for setting weekly news subscriptions
				echo '<tr>';
				echo   '<td colspan=2 style="color:black">';
				echo 'Send me weekly ZLOOP newsletter : ';
				echo $form->checkBox($model,'sendWeeklyEmail');
				echo '</td>';
				echo '</tr>';
			}
		?>	  
	  <tr> 
	    <td>
	    	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	    </td>
	  </tr>
	  
	</table>
</div><!-- user info -->

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript" language="javascript">
<!--
function OpenPopupTerms (c, title) {
	window.open(c,
	title,
	"width=680,height=480,scrollbars=1,status=0,toolbar=0,location=0");
	}
//--> </script> 

