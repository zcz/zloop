<?php 

$content = $this->widget("ItemDisplayWidget", 
				array(
					"isBar"=>false, 
					'categoryId'=>0, 
					'ownerid'=>$model->id,
					'specialAction' => "commented",
					'totalItemNumber'=>4,
					'rowNumber'=>1,
					'columnNumber'=>4,
					'displayContent'=>false
				))->run();

$this->widget("DisplayBox", 
	array(
		'title' => "My interest:",
		'moreLink' => CHtml::link("More", array("/user/moreCommentedItems")),
		'content' => $content
));

?>