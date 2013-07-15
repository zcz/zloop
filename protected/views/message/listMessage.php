<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'/message/viewOneMessage',
	'emptyText'=>'No Messages.',
)); ?>
