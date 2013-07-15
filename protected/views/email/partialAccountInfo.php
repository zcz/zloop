<h2
	style="font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; margin-top: 0pt; margin-right: 0pt; margin-bottom: 16px; margin-left: 0pt; font-size: 18px;">
	Hi, <?php echo $user->username?>.
</h2>

<p>
	<?php 
	
		if (!function_exists('turnToBold')) {
			function turnToBold($s) {
				return('<b>' . $s . '</b>');
			}
		}

		$s = "<div>";

		$s .= "<div style='margin:10px;'>";
		$s .= "<div style=\"font-size: 16px;\">";
		$s .= "<p>Welcome to zloop, your account has been created or updated.</p>";
		
		$s .= "<table border=\"0\">";
		$s .= "<tr><td align=\"left\" width=\"100px\">Email:</td><td>$user->email</td></tr>";
		$s .= "<tr><td align=\"left\" width=\"100px\">Username:</td><td>$user->username</td></tr>";
		$s .= "<tr><td align=\"left\" width=\"100px\">Password:</td><td>$password</td></tr>";
		$s .= "</table>";

		$s .= "</div>";
		
		echo $s;
	?>
	
</p>