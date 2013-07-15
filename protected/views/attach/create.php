<?php
$this->breadcrumbs=array(
	'Attaches'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Attach', 'url'=>array('index')),
	array('label'=>'Manage Attach', 'url'=>array('admin')),
);
?>

<h1>Create Attach</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>