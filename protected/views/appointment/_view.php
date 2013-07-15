<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parentid')); ?>:</b>
	<?php echo CHtml::encode($data->parentid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemid')); ?>:</b>
	<?php echo CHtml::encode($data->itemid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fromuserid')); ?>:</b>
	<?php echo CHtml::encode($data->fromuserid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('touserid')); ?>:</b>
	<?php echo CHtml::encode($data->touserid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meetingtime')); ?>:</b>
	<?php echo CHtml::encode($data->meetingtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meetingaddress')); ?>:</b>
	<?php echo CHtml::encode($data->meetingaddress); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reply')); ?>:</b>
	<?php echo CHtml::encode($data->reply); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('confirmed')); ?>:</b>
	<?php echo CHtml::encode($data->confirmed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	*/ ?>

</div>