<?php 

$content = $this->widget("ItemDisplayWidget", 
				array(
					"isBar"=>false, 
					'categoryId'=>0, 
					'ownerid'=>$model->id,
					'specialAction' => Yii::app()->params['specialAction_view'],
					'totalItemNumber'=>4,
					'rowNumber'=>1,
					'columnNumber'=>4,
					'displayContent'=>false,
				))->run();

$this->widget("DisplayBox", 
	array(
		'title' => "View history:",
		'moreLink' => CHtml::link("More", array("/user/moreViewedItems")),
		'content' => $content
));

?>