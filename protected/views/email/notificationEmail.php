<html>
<div id=":ya" class="ii gt">
	<div id=":y9">
		<div
			style="background-color: rgb(255, 255, 255); color: rgb(34, 34, 34);"
			lang="en">
			<div
				style="font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; font-size: 13px; margin: 14px;">
				<h2
					style="font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; margin-top: 0pt; margin-right: 0pt; margin-bottom: 16px; margin-left: 0pt; font-size: 18px;">
					Hi, <?php echo $model->username?>.
				</h2>

				<p>
					Please notice you have new messages, 
					
					you can check them at 
					<a href="http://www.zloop.net" target="_blank">
						ZLOOP
					</a>. 
					
					<?php

						if (!function_exists('turnToRedBold')) {
							function turnToRedBold($s) {
								return('<b style="color: rgb(255, 0, 0); font-family: Tahoma; text-align: justify; background-color: rgba(255, 255, 255, 0.917969); ">' . $s. '.</b>');
							}
						}

						if (!function_exists('turnToBold')) {	
							function turnToBold($s) {
								return('<b style="font-style: italic;">' . $s . '</b>');
							}
						}

					
						$messageList = $notice->messageList;
						$commentList = $notice->commentList;
						$replyList = $notice->replyList;
						
						if (count($messageList) !== 0)
						{
							foreach ($messageList as $i => $data)
							{
								$text = turnToBold($data->fromuser->username) ." sent you a message.";
								$link = '<p>' .$text. '</p>';
								echo $link;
							}
						}
						
						if (count($commentList) !== 0)
						{
							foreach ($commentList as $i => $data)
							{
								$text = turnToBold($data->user->username) . " asked you a question on the item ";
								$text .= turnToRedBold($data->item->title);
								$link = '<p>'.$text.'</p>';
								echo $link;
							}
						}
						
						if (count($replyList) !== 0)
						{
							foreach ($replyList as $i => $data)
							{
								$text = turnToBold($data->item->user->username) . " answered your question on the item ";
								$text .= turnToRedBold($data->item->title);
								$link = '<p>'.$text.'</p>';
								echo $link;
							}
						}
												
					?>
					
				</p>

				<p>
					You can check at 
					<a href="http://www.zloop.net" target="_blank">
						ZLOOP
					</a>.	
				</p>

				<p	style="font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; font-size: 13px; line-height: 18px; border-bottom: 1px solid rgb(238, 238, 238); padding-bottom: 10px; margin: 0pt 0pt 10px;">
					<span style="font: italic 13px Georgia, serif; color: rgb(102, 102, 102);">
						Thanks,<br>The ZLOOP Team
					</span>

				</p>

				<p
					style="font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; margin-top: 5px; font-size: 10px; color: rgb(136, 136, 136);">

					Please do not reply to this message; it was sent from an
					unmonitored email address. This message is a service email related
					to your use of ZLOOP. For general inquiries or to request support
					with your ZLOOP account, please visit us at 
					<a href="http://www.zloop.net" target="_blank">
						ZLOOP
					</a>.
					&nbsp;&nbsp;
				</p>


			</div>
		</div>
	</div>
</div>
</html>
