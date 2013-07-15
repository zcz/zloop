<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('item-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php 

$widget = $this->createWidget('zii.widgets.grid.CGridView', array(
	'id'=>'item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CButtonColumn',
			'updateButtonLabel'=>"Edit item",
		),
		'id',
		'title',
		array(            // display 'create_time' using an expression
            'name'=>'create_time',
            'value'=>'date("M j, Y", $data->create_time)',
		),
		array(            // display 'categoryid' using an expression
            'name'=>'categoryid',
            'value'=>'$data->category->title',
		),
		array(            // display 'conditionid' using an expression
            'name'=>'conditionid',
            'value'=>'$data->condition->title',
		),
		array(            // display 'viewTimes' using an expression
            'name'=>'viewTimes',
            'value'=>'$data->status->viewnum',
		),
		'summary',
	),
)); 

$this->widget("DisplayBox",
array(
		'title' => "Manage Items",
		'widget' => $widget,
		'withSpaceAround' => false,
		'withSpaceTopBottom' => false,
));



?>

