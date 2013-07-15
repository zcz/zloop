<STYLE type="text/css">

.the-visitor-banner {
	background-color:whiteSmoke;
	width : 750px;
	height: 265px;
}

.welcome-title {
	width : 100%;
	height : 49px;
	text-align : center;
	font-size : 35px;
	padding-top : 20px;
	padding-bottom : 10px;
	color: #F60;
	color: #5872A7;
	font-family: 'Comic Sans MS';
}

.facebook-body {
	width : ;
	padding-top: 10px;
	padding-left: 70px;
	padding-right: 70px;
	height : 107px;
}

.facebook-friends {
	width : 300px;
	height : 100%;
	float : left; 
}

.facebook-login {
	width : 300px;
	height : 100%;
	float : left;
	text-align : center;
} 

.fb-login-button-div {
	width : 200px;
	margin : auto;
}

.facebook-login-with-words {
	padding-top: 20px;
	width : 200px;
	padding-bottom: 3px;
	height : auto;
	margin : auto;
}

.facebook-permission {
	font-size : 11px;
}

.or-seperator {
	text-align: center;
	font-size : 100%;
	font-family: 'Comic Sans MS';
}

.create-account {
	padding-top: 3px;
	width : 324px;
	margin : auto;
}

.create-account a {
	text-decoration: none;
	color: #1D95CB;
	text-align: center;
	font-size : 16px;
	font-family: 'Comic Sans MS';
} 

.facebook-log-in-box-img-large { 
	width:200px;
	height: auto;
}

</STYLE>



<div class="the-visitor-banner">

	<div class="welcome-title">
		welcome to zloop
	</div>
	
	<div class="facebook-body">
	
		<div class="facebook-friends">
			<div class="fb-login-button-div">
				<div class="fb-login-button" 
					data-show-faces="true" 
					data-width="200" 
					data-max-rows="1">
				</div>
			</div>
		</div>
		
		<div class="facebook-login">
			<div class="facebook-login-with-words">
				 <a href="<?php echo Yii::app()->createAbsoluteUrl("/facebook/login");?>">				
				 	<img class="facebook-log-in-box-img-large"
					src="/images/decoration/facebook_connect_button.png" />
				</a>
			</div>
			<span class="facebook-permission">* We don't post anything without your permission.</span>
		</div>
		
		<div class="clearAllDiv"></div>
	
	</div>
	
	<div class = "or-seperator">
		-------------------------------------------------------- or --------------------------------------------------------
	</div>
	
	<div class="create-account">
		<a href="<?php echo Yii::app()->createAbsoluteUrl("/user/create");?>">
			Create an account with your email address
		</a>
	</div>

</div>
