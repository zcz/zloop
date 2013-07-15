<?php 
$content = $this->renderPartial(
	'_f_item', 
	array(
		'model'=>$model, 
		'tags'=>$tags,
		'tagSelected'=>$tagSelected,
	), true
); 

$this->widget("DisplayBox",
	array(
		'title' => "Create Item",
		'content' => $content,
));
?>