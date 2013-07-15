<?php 
$this->widget( 
  'ext.EChosen.EChosen', 
  array(
    'target'=>'select',
	'useJQuery' => true,
    'debug'=> true,
    
  ) ); 
?>
	
<div class="row">
	<?php //echo $form->labelEx($model,'conditionid'); ?>		
	<?php echo $form->dropDownList($model, 'conditionid', 
		Condition::model()->getConditionListForCreate(), 
	    array('data-placeholder'=>'Item condition is:', 'style'=>"width: 310px;")); ?>
</div>
