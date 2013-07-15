<?php
$this->breadcrumbs=array(
	'Appointments'=>array('index'),
	'Create',
);

?>

<h1>Create Appointment</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>