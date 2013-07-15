<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

<div style='width:90%; position:relative; left:40px;'>

<table border='0'>

	<tr>
		<td colspan="1" width=80px>
			<?php echo $form->labelEx($model,'categoryid'); ?>
		</td>
		<td colspan="2">
		
		<script type="text/javascript">
		function showConfirmChangeCategory(s)
		{
			var r=confirm("You will lost unsaved changes.\nContinue?");
			if (r==true){
				//alert(s);
				window.location = s;
			}
		
		}
		</script>
			<?php 
				echo $model->category->getFullName() . "&nbsp;&nbsp;&nbsp;";
				//echo " ".CHtml::link("Change", Yii::app()->createUrl("category/listAllCategories"));
				
				$paraUrl = 'showConfirmChangeCategory("'.Yii::app()->createUrl("category/listAllCategories").'")';
				echo '<input type="button" onclick='.$paraUrl.' value="Change" />';
			?>
		</td>
	</tr>

	<tr>
		<td colspan="1">
			<?php echo $form->labelEx($model,'title'); ?>
		</td>
		<td colspan="2">
			<?php echo $form->textField($model,'title', array("size"=>'78')); ?>
		</td>
	</tr>

	<tr>
		<td><?php echo $form->labelEx($model,'propertyName');?></td>
		<td colspan="1">
			<?php
				//invisible, just to hold the value
				echo $this->renderPartial('/category/invisibleForm', 
					array(
						'model'=>$model, 
						'form'=>$form,
					));
			
				echo $form->labelEx($model,'price');
				echo " from: ";
				echo $form->textField($model,'pricelow', array("size"=>'3'));
				echo " to ";
				echo $form->textField($model,'pricehigh', array("size"=>'3'));
			?>
		</td>
		<td colspan="1">
			<?php
			
			if ($model->conditionid == Yii::app()->params['categorySold'])
			{
				echo "<b>Condition:</b> This is already marked as sold.";
			} else
			if ($model->conditionid == Yii::app()->params['conditionExpired']) {
				echo "<b>Condition:</b> This item is expired.";
			} else {
				echo $this->renderPartial('/condition/_form', 
					array(
						'model'=>$model, 
						'form'=>$form,
					));
			}
			?>		
		</td>
	</tr>
	<tr>
		<td><?php echo $form->labelEx($tags,'tagName');?></td>
		<td colspan="1">
			<div>
			<?php 
				echo $form->textField($tags,'tagName', array('size'=>'28')); 	
				echo CHtml::submitButton('Add Tags', array("name"=>"addTag"));
			?>
			</div>
		</td>
		<td colspan="1">
			<?php
				echo $this->renderPartial('/tag/_form', 
						array('model'=>$tags, 'selected'=>$tagSelected, 'form'=>$form));
			?>
		</td>
	</tr>
	<tr>
		<td><?php echo $form->labelEx($model,'presentation');?></td>
		<td colspan='2'>
			<?php
				echo $this->renderPartial('_f_text', array('model'=>$model, 'form'=>$form));
			?>
		</td>
	</tr>
</table>

</div>

<div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create and add Pictures' : 'Save and add Pictures', array("name"=>"submitForm")); ?>
</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
