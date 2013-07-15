<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- Update your html tag to include the itemscope and itemtype attributes, from google -->
<!-- <html itemscope itemtype="http://schema.org/LocalBusiness"></html> -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
<head>


<!-- Add the following three tags inside head -->
<!-- 	<meta itemprop="name" content="Zloop"> -->
<!-- 	<meta itemprop="description" content=""> -->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta property="og:title" content="" />
	
	
	<meta property="og:type" content="link" />
	<meta property="og:url" content="<?php echo Yii::app()->request->requestUri;?>" />
	<meta property="og:title" content="<?php echo $this->title_forShare; ?>" />
	<meta property="og:description" content="<?php echo $this->description_forShare; ?>" />
	<meta property="og:image" content="<?php echo $this->image_forShare; ?>" />
	<meta property="og:photo" content="<?php echo $this->image_forShare; ?>" />
	<meta property="og:site_name" content="zloop.net" />
	<meta property="og:abstract" content="<?php echo $this->description_forShare; ?>" />
	<meta property="fb:admins" content="1085451198" />
	
	<!-- for facebook share property -->
	<meta name="title" content="<?php echo $this->title_forShare; ?>" />
	<meta name="description" content="<?php echo $this->description_forShare; ?>" />
	<meta name="Keywords" content="zloop polyu hk second hand goods exchange students books" />
	<link rel="image_src" href="<?php echo $this->image_forShare; ?>" />

	<!-- blueprint CSS framework -->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26341222-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/protected/extensions/jQuery/jquery-1.7.1.min.js"></script>

<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>


<!-- facebook scripts for like button -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '202321366523553', // App ID
      channelUrl : 'http://www.zloop.net/docs/forProgram/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    // Additional initialization code here
  };
  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=202321366523553";
     ref.parentNode.insertBefore(js, ref);
   }(document));
</script>

<div class="container" id="page">

	<?php $this->renderPartial('/layouts/parts/top');?>		
	
	<?php echo $content; ?>

	<div id="footer">

		Copyright &copy; <?php echo date('Y'); ?> by zloop. 
		All Rights Reserved.
	</div>


<!-- footer -->

</div><!-- page -->

</body>
</html>
