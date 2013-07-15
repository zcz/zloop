<?php 

$content = $this->widget("ItemDisplayWidget", 
				array(
					"isBar"=>false, 
					'categoryId'=>0,
					'ownerid'=>$model->id,
					'totalItemNumber'=> 8,
					'rowNumber'=>2,
					'columnNumber'=>4,
					'displayContent'=>false,
				))->run();

$this->widget("DisplayBox", 
	array(
		'title' => "My Items:",
		'moreLink' => CHtml::link("More", array("/user/moreItems", 'id'=>$model->id)),
		'content' => $content,
));

?>
