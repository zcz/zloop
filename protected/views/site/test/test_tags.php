<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'test_tag',
)); 
?>

<?php 
	echo $form->textField($model,'tagName'); 	
	echo CHtml::submitButton('Add Tags', array("name"=>"addTag"));
	echo "<br/><br/>";	
?>

<?php
$this->widget(
  'ext.EChosen.EChosen', 
array(
    'target'=>'select',
	'useJQuery' => true,
    'debug'=> true,
) );
?>
	
<?php

	$showList = TagUser::model()->getTagUserList($selected, $selectList);

	echo $form->dropDownList($model, 'id', 
		$showList, 
		array(
			'content'=>"charset=utf-8",
			'data-placeholder'=>'Choose Tags', 
			'style'=>"width: 30%;",
			'multiple class'=>"chzn-select",
			'options'=>$selectList,
			'multiple' => 'multiple'
		)
	); 
?>


<?php 

echo "<br/>";
echo CHtml::submitButton('submit', array("name"=>"submitForm")); 

?>

<?php $this->endWidget(); ?>
