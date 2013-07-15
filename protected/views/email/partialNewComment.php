<h2
	style="font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; margin-top: 0pt; margin-right: 0pt; margin-bottom: 16px; margin-left: 0pt; font-size: 18px;">
	Hi, <?php echo $comment->item->user->username?>.
</h2>

<p>
	<?php 
	
		if (!function_exists('turnToBold')) {
			function turnToBold($s) {
				return('<b>' . $s . '</b>');
			}
		}
	
		$s = "<div>";
		$s .= turnToBold($comment->user->username);
		$s .= " asked a question on ";
		$s .= "[Item : " . turnToBold($comment->item->title) . "] : ";
		$s .= "</div>";
		
		$s .= "<div style='margin:10px;'>";
		$s .= "<div  style=\"font-size: 20px;\"> Q: ".$comment->content . "</div>";
		$s .= "</div>";
		
		echo $s;
	?>
	
</p>

<p>
	You can check at 
	<a href="http://www.zloop.net" target="_blank">
		ZLOOP
	</a>.	
</p>