<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastview')); ?>:</b>
	<?php echo CHtml::encode($data->lastview); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastcomment')); ?>:</b>
	<?php echo CHtml::encode($data->lastcomment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastreply')); ?>:</b>
	<?php echo CHtml::encode($data->lastreply); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('viewnum')); ?>:</b>
	<?php echo CHtml::encode($data->viewnum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemid')); ?>:</b>
	<?php echo CHtml::encode($data->itemid); ?>
	<br />


</div>