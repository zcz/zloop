<?php
$this->breadcrumbs=array(
	'Pics'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pic', 'url'=>array('index')),
	array('label'=>'Create Pic', 'url'=>array('create')),
	array('label'=>'View Pic', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Pic', 'url'=>array('admin')),
);
?>

<h1>Update Pic <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>