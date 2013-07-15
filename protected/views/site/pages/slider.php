<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/slider.css" type="text/css" media="screen" />
<div id="wrapper">
	<div class="slider-wrapper theme-default">
		<div class="ribbon"></div>
		<div id="slider" class="nivoSlider">
			<a href="<?php echo Yii::app()->createAbsoluteUrl("/item/index");?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/slider/banner-1_s.jpg" alt="" /></a>
			<a href="<?php echo Yii::app()->createAbsoluteUrl("/item/create");?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/slider/banner-2_s.jpg" alt="" /></a>
			<a href="<?php echo Yii::app()->createAbsoluteUrl("/site/about");?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/slider/banner-4_s.jpg" alt="" /></a>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/protected/extensions/jQuery/slider/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
	$(window).load(function() {
		$('#slider').nivoSlider();
	});
</script>