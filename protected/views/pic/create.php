<?php
$this->breadcrumbs=array(
	'Pics'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pic', 'url'=>array('index')),
	array('label'=>'Manage Pic', 'url'=>array('admin')),
);
?>

<h1>Create Pic</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>