<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fromid')); ?>:</b>
	<?php echo CHtml::encode($data->fromid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('toid')); ?>:</b>
	<?php echo CHtml::encode($data->toid); ?>
	<br />


</div>