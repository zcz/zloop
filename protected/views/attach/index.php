<?php
$this->breadcrumbs=array(
	'Attaches',
);

$this->menu=array(
	array('label'=>'Create Attach', 'url'=>array('create')),
	array('label'=>'Manage Attach', 'url'=>array('admin')),
);
?>

<h1>Attaches</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
