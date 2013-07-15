<h2
	style="font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; margin-top: 0pt; margin-right: 0pt; margin-bottom: 16px; margin-left: 0pt; font-size: 18px;">
	Hi, <?php echo $item->user->username?>.
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
		$s .= "<p>Your ";
		$s .= "<a href=\"" . $item->getUrl() ."\">item (". turnToBold($item->title) . ")</a>";  
		$s .= " is going to expire on " . date('Y-m-d',$item->expire_time) . ".</p>";
		$s .= "<p>If currently that item is still available, please ";
		$s .= "<a href=\"" . $item->getUrlForRenewItem() . "\">renew</a>";
		$s .= " it.</p>";
		$s .= "Once an item expired, other users can no longer find it in the system.";
		$s .= "</div>";
		$s .= "</div>";
		
		$s .= "P.S. It is our policy that an item will be expired in 30 days without renewal, ";
		$s .= "in order to maintain zloop an active platform.";
		
		$s .= "</div>";
		
		echo $s;
	?>
	
</p>