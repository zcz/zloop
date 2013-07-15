<!--This file codes the top toolbar. It will be called by main.php-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/notifications.css" media="screen" rel="stylesheet" type="text/css" /> 
<script type="text/javascript">
	function expand(s)
	{
	  var li = s;
	  var u = li.getElementsByTagName("ul").item(0);

	  if(li.className == "notification-button")
	  {
		li.className = "notification-clicked";
	  }
	  else
	  {
		li.className = "notification-button";
	  }
	  if(u.className == "notifications-hide")
	  {
	    u.className = "notifications-sub";
	  }
	  else
	  {
		u.className = "notifications-hide";
	  }
	}
</script>

<div class="toolbar">
	
	<?php $this->widget('Notification'); ?>
		
	<span id="toolbar">
		<?php if(Yii::app()->user->isGuest): ?>
			<a href="<?php echo Yii::app()->createAbsoluteUrl("/facebook/login");?>">Facebook Login</a> | 
			<a href="<?php echo Yii::app()->createAbsoluteUrl("/site/login");?>">Sign In</a> | 
			<a href="<?php echo Yii::app()->createAbsoluteUrl("/user/create");?>">Create Account</a> <!--  |
			<a href="<?php echo Yii::app()->createAbsoluteUrl("/site/contact");?>">Give us feedback</a> -->
		<?php else: ?>
			<a href="<?php echo Yii::app()->createAbsoluteUrl("/user/viewMe");?>"><?php echo Yii::app()->user->name;?></a> |
			<a href="<?php echo Yii::app()->createAbsoluteUrl("/site/logout");?>">Log Out</a>
		<?php endif; ?>
	</span>
</div>