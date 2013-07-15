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
	<?php echo $form->dropDownList($model, 'categoryid', 
		Category::model()->getCategoryList(), 
	    array('data-placeholder'=>'choose a category', 'style'=>"width: 310px;")); ?>
</div>
