<?php
$this->breadcrumbs=array(
	'Attaches'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Attach', 'url'=>array('index')),
	array('label'=>'Create Attach', 'url'=>array('create')),
	array('label'=>'View Attach', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Attach', 'url'=>array('admin')),
);
?>

<h1>Update Attach <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>