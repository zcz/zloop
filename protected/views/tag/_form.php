<?php 
	$this->widget(
	  'ext.EChosen.EChosen', 
	array(
	    'target'=>'select',
		'useJQuery' => true,
	    'debug'=> true,
	) );

	$showList = TagUser::model()->getTagUserList($selected, $selectList);

	echo $form->dropDownList($model, 'id', 
		$showList, 
		array(
			'content'=>"charset=utf-8",
			'data-placeholder'=>'Add tags will help others find items', 
			'style'=>"width: 100%;",
			'multiple class'=>"chzn-select",
			'options'=>$selectList,
			'multiple' => 'multiple'
		)
	); 

?>