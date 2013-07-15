<div class="message-wrapper">
	<div class="message-container">	
		<div class="message-content">
			<div class="message-title">
				
				<?php 
					$s = "";

					$s .= CHtml::image(Pic::model()->getUserPic($data->fromuser), "", array('class'=>"message-profile-picture"));
					
					$s .= $data->fromuser->username;
					echo $data->fromuser->getGeneralLink( $s );
				
					echo "&nbsp;to&nbsp;";
				
					echo $data->touser->getNameLink(); 
					echo "&nbsp;(".date('Y-m-d h:m:s',$data->create_time).")";
					if ($data->isprivate) {
						echo " (private) ";
					}
				
					$reply_link = "";
					if ($data->toid == Yii::app()->user->id) {
						$reply_link = $data->getReplyLink(array('class'=>'reply-message'));
						$reply_link = '<small class="reply">' . $reply_link . '</small>';
					} else {
						$reply_link = "";
					}
					echo $reply_link;
				
				?>
					
			</div>
			<p>
				<?php echo CHtml::encode($data->content);?>
			</p>
		</div>
	</div>
</div>
