<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div class="span-24">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	
	<div class="span-5 last">

	<div id="sidebar">
	    <?php if(!Yii::app()->user->isGuest) $this->widget('UserMenu'); ?>
	    <?php if(!Yii::app()->user->isGuest) $this->widget('Notification'); ?>
	</div>

	</div>
</div>
<?php $this->endContent(); ?>
