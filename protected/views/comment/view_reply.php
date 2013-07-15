<?php
/*
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	$model->id,
);
*/
?>

<?php 

//comment part
$content  = $this->renderPartial('_v_comment', array('data'=>$model), true);

//continue to ask a question part
$commentForm = new Comment("create");
$commentForm->itemid = $model->item->id;
if (!($model->item->userid == Yii::app()->user->id)) {
	//a user can not leave question to him/her self
	$content .= $this->widget("DisplayBox",
	array(
			'title' => "Ask a Question: ",
			'content' =>  $this->renderPartial('/comment/_f_comment', array('model'=>$commentForm), true),
			'withSpaceAround' => false,
	), true);
}

//item head part
$content .= $this->renderPartial( "/item/itemHead" , array('item'=>$model->item), true);

$this->widget("DisplayBox",
array(
		'title' => "Reply for : <span class=\"my_orange_words\">" . $model->item->title . "</span>",
		'content' => $content
));

?>





