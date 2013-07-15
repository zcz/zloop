<div class="all-message-container">

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'/message/viewOneMessage_Beauty',
	'emptyText'=>'No Messages.',
)); ?>

</div>