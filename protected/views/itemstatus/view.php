<?php
$this->breadcrumbs=array(
	'Itemstatuses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Itemstatus', 'url'=>array('index')),
	array('label'=>'Create Itemstatus', 'url'=>array('create')),
	array('label'=>'Update Itemstatus', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Itemstatus', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Itemstatus', 'url'=>array('admin')),
);
?>

<h1>View Itemstatus #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'lastview',
		'lastcomment',
		'lastreply',
		'viewnum',
		'itemid',
	),
)); ?>
