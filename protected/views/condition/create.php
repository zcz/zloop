<?php
$this->breadcrumbs=array(
	'Conditions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Condition', 'url'=>array('index')),
	array('label'=>'Manage Condition', 'url'=>array('admin')),
);
?>

<h1>Create Condition</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>