<?php 

$dataProvider->setPagination(array('pageSize'=>30));

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'/item/_i_item',
	"separator"=>"",
	'itemsCssClass' => 'itemListItemsCSS',
)); 

?>