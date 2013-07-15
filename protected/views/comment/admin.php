<?php
/*
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	'Manage',
);
*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('comment-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Comments: <?php echo $model->item->title;?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'comment-grid',
	'dataProvider'=>$model->searchForReply(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'userid',
			'value'=>'$data->user->username',
		),
		'content',
		'reply',
		array(
			'class'=>'CButtonColumn',
		),
	),
));

echo "<br/><br/>";
?>


