<?php
$this->breadcrumbs=array(
	'Itemstatuses',
);

$this->menu=array(
	array('label'=>'Create Itemstatus', 'url'=>array('create')),
	array('label'=>'Manage Itemstatus', 'url'=>array('admin')),
);
?>

<h1>Itemstatuses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
