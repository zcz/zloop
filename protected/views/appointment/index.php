<?php
$this->breadcrumbs=array(
	'Appointments',
);

?>

<h1>Appointments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
