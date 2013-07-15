<?php
$this->breadcrumbs=array(
	'Itemstatuses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Itemstatus', 'url'=>array('index')),
	array('label'=>'Manage Itemstatus', 'url'=>array('admin')),
);
?>

<h1>Create Itemstatus</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>