<?php
$this->breadcrumbs=array(
	'Itemstatuses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Itemstatus', 'url'=>array('index')),
	array('label'=>'Create Itemstatus', 'url'=>array('create')),
	array('label'=>'View Itemstatus', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Itemstatus', 'url'=>array('admin')),
);
?>

<h1>Update Itemstatus <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>