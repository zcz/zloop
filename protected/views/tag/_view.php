<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tagName')); ?>:</b>
	<?php echo CHtml::encode($data->tagName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numview')); ?>:</b>
	<?php echo CHtml::encode($data->numview); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numused')); ?>:</b>
	<?php echo CHtml::encode($data->numused); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />


</div>