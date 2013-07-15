<?php 
//manage comments
if (isset($manageComment) && $manageComment === true && Yii::app()->user->id == $model->userid && $model->status->lastcomment != 0)
{
	$outputManageComment = '('.CHtml::link(CHtml::encode("manage comments"), array('comment/admin', 'itemid'=>$model->id)).')';
}else $outputManageComment = "";

echo $outputManageComment;
?>

<?php 

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(               
        	    	'label'=>'Owner',
       		     	'type'=>'raw',
        	    	'value'=>$model->user->username,
        ),
		array(
			'label'=>'Category',
			'type'=>'raw',
			'value'=>$model->category->getFullName(),
		),
	),
));

echo $model->presentation;
 
?>
