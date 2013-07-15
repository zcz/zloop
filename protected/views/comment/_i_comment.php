<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'/comment/_v_comment',
	'emptyText'=>'No Questions.',
)); ?>
