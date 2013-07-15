<table id="header">
	<tr>
		<td width="25%">
			<div>
			<a href="<?php echo Yii::app()->createAbsoluteUrl("");?>">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo_beta_small.png" id="logo"/>
			</a>
			</div>
		</td>

		<td width="50%" align="center"><!--search bar-->
			<div>
				<?php $this->widget('SearchBar');?>
			</div>
		</td>

		<td align="center">
		
			<table>
				<!-- 
				<tr>
					<td>
						<?php //echo '<a href="'.Yii::app()->createUrl('/site/downloadVideo').'"> introduction video </a>' ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php //echo " "; ?>
					</td>
				</tr>
				 <tr>
					<td>
						<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.zloop.net" data-counturl="http://www.zloop.net" data-count="horizontal" data-via="#" data-text="ZLOOP">Tweet</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo " "; ?>
					</td>
				</tr>
								 -->
				
				<tr>
					<td>
						<div class="fb-like" data-href="http://zloop.net:1503"  data-send="false" data-width="150" data-show-faces="false" data-font="trebuchet ms"></div>
					</td>
				</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td id="navigation" colspan="3">
			<ul>
				<?php 
					echo "<li><a href=".Yii::app()->createUrl("")."><img src=".Yii::app()->request->baseUrl.'/images/menu/home.png width="35px" height="35px">Home</a></li>';
					echo "<li><a href=".Yii::app()->createUrl("/user/viewMe")."><img src=".Yii::app()->request->baseUrl.'/images/menu/my_zloop.png width="35px" height="35px">My ZLOOP</a></li>';
					echo "<li><a href=".Yii::app()->createUrl('/item/create')."><img src=".Yii::app()->request->baseUrl.'/images/menu/upload_item.png width="35px" height="35px">Post Item</a></li>';
					echo "<li><a href=".Yii::app()->createUrl('/item/admin')."><img src=".Yii::app()->request->baseUrl.'/images/menu/banshou.png width="33px" height="33px">Manage Items</a></li>';
					echo "<li><a href=".Yii::app()->createUrl('/site/tagCloud')."><img src=".Yii::app()->request->baseUrl.'/images/menu/cloud.png width="35px" height="35px">Tag Cloud</a></li>';
					echo "<li><a href=".Yii::app()->createUrl('/site/contact')."><img src=".Yii::app()->request->baseUrl.'/images/menu/email_icon.png width="35px" height="35px">Contact us</a></li>';
					echo "<li><a href=".Yii::app()->createUrl('/site/about').' id="help">About</a></li>';
					//echo '<li><a href="https://docs.google.com/spreadsheet/viewform?formkey=dEFhT2RCdmxsMWloc1d1d2U5VjFxMkE6MQ" id="help"><b>Survey</b></a></li>';
				?>
			</ul>
		</td>
	</tr>
</table>
