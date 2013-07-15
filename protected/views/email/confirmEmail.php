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
					Please activate your ZLOOP account by clicking this link: <br> 
					<a	href=<?php echo $model->getConfirmUrl();?> target="_blank">
						<?php echo $model->getConfirmUrl(); ?>
					</a>
				</p>

				<p>
					Once you activate it, you will have full access to ZLOOP and all
					future notifications will be sent to this email address.
				</p>

				<p	style="font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; font-size: 13px; line-height: 18px; border-bottom: 1px solid rgb(238, 238, 238); padding-bottom: 10px; margin: 0pt 0pt 10px;">
					<span style="font: italic 13px Georgia, serif; color: rgb(102, 102, 102);">
						Thanks,<br>The ZLOOP Team
					</span>

				</p>


				<p style="font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; margin-top: 5px; font-size: 10px; color: rgb(136, 136, 136);">
					
					If you received this message in error and did not sign up for a ZLOOP account, click 
					<a href=<?php echo $model->getNotMeUrl();?> target="_blank">
						not my account
					</a>.
				</p>


				<p
					style="font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; margin-top: 5px; font-size: 10px; color: rgb(136, 136, 136);">

					Please do not reply to this message; it was sent from an
					unmonitored email address. This message is a service email related
					to your use of ZLOOP. For general inquiries or to request support
					with your ZLOOP account, please visit us at 
					<a href=<?php echo $model->getBaseSiteUrl();?> target="_blank">
						ZLOOP
					</a>.
					&nbsp;&nbsp;
				</p>


			</div>
		</div>
	</div>
</div>
</html>
