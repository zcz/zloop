<?php
/*
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
*/
?>

<?php 

$content  = $this->renderPartial('_v_comment', array('data'=>$model), true); 
$content .= $this->renderPartial('_form', array('model'=>$model), true); 
$content .= $this->renderPartial( "/item/itemHead" , array('item'=>$model->item), true);

$this->widget("DisplayBox",
array(
		'title' => "Question for : <span class=\"my_orange_words\">" . $model->item->title . "</span>",
		'content' => $content
));

?>