<?php 

$content = $this->renderPartial(
	'/item/_f_item', 
	array(
		'model'=>$model, 
		'tags'=>$tags,
		'tagSelected'=>$tagSelected,
	), true
); 

$this->widget("DisplayBox",
	array(
		'title' => "Update Item: ". $model->title,
		'content' => $content,
));
?>
