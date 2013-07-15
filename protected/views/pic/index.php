<?php
$this->breadcrumbs=array(
	'Pics',
);

$this->menu=array(
	array('label'=>'Create Pic', 'url'=>array('create')),
	array('label'=>'Manage Pic', 'url'=>array('admin')),
);
?>

<h1>Pics</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
