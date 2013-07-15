<div class="form">

<?php 
$this->widget( 
  'ext.EChosen.EChosen', 
  array(
    'target'=>'select',
	'useJQuery' => true,
    'debug'=> true,
    
  ) ); 
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'key-search-form',
	'enableAjaxValidation'=>true,
)); ?>

<?php 
	if (!isset($hide_category)) 
	{
		echo $form->dropDownList(
				$model, 
				'categoryid', 
				Category::model()->getCategoryListForDisplay(),
				array(
					'data-placeholder'=>'', 
					'style'=>"width: 200px;"
				)
			);
		echo $form->dropDownList(
				$model,
				'conditionid', 
				Condition::model()->getConditionListForDisplay(),
				array(
					'data-placeholder'=>'', 
					'style'=>"width: 200px;"
				)
			);
	}
?>
	
	<?php echo $form->textField($model,'keyString',array("size"=>"30")); ?>	
	<?php echo CHtml::submitButton('Search'); ?>	
	
<?php $this->endWidget(); ?>
</div><!-- form -->
