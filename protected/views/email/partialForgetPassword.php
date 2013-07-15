<h2
	style="font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; margin-top: 0pt; margin-right: 0pt; margin-bottom: 16px; margin-left: 0pt; font-size: 18px;">
	Hi, <?php echo $user->username?>.
</h2>

<p>
	You can get a new ZLOOP account password by clicking this link: <br> <a
		href=<?php echo $user->getForgetPasswordUrl();?> target="_blank">
		<?php echo $user->getForgetPasswordUrl(); ?> </a>
</p>

<p>If clicking the link above doesn't work, please copy and 
paste the URL in a new browser window instead.</p>

<p>
If you've received this mail in error, it's likely that another user entered
your email address by mistake while trying to reset a password. If you  
didn't initiate the request, you don't need to take any further action and can  
safely disregard this email.
</p>