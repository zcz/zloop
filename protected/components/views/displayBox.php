<div <?php if ($spaceTopBottom) echo 'class = "someSpacesTopBottom"';?> name="123">
	<div <?php if ($space) echo 'class = "someSpaces"';?> name="234">
		<div class = "boxWithTitle">
			<div class = "aWholeTitle">
				<div class = "headline"> 
					<?php echo $title; ?> 
				</div>
				<div class = "headline-right" > 
					<?php echo $moreLink?>
				</div>
				<div class = "clearAllDiv" ></div>
			</div>
			<div class = "payloadContent"> 
				<?php 
					if ($widget != null) {
						$widget->run();
					} else {
						echo $content; 
					}
				?> 
			</div>
			<div class = "clearAllDiv" ></div>
		</div>
		<div class = "clearAllDiv" ></div>
	</div>
	<div class = "clearAllDiv" ></div>
</div>