<table>
	<tr>
		<td width="20%" valign="top" style="padding:0px">
			<?php //$this->renderPartial('/site/categoryNavigation');?>
			<?php $this->widget('CategoryNavigation', array('categoryId'=>0));?>
		</td>
		<td valign="top">
			<?php 
				if (Yii::app()->user->isGuest) {
					$this->renderPartial('/site/pages/visitorBanner');
				} else {
					$match=preg_match('/MSIE ([0-9]\.[0-9])/',$_SERVER['HTTP_USER_AGENT'],$reg);
					
					if($match==0)
						$this->renderPartial('/site/pages/slider');
					else if (floatval($reg[1])<9)
						$this->renderPartial('/site/pages/slider_ie');
					else
						$this->renderPartial('/site/pages/slider');
				}				
			?>
		</td><!-- content -->
	</tr>
</table>
<table style="margin-top:15px">
	<tr>
		<td align="center">
		<?php 		
			$this->widget("ItemDisplayWidget", array("isBar"=>false,
			'totalItemNumber'=>6,
			'rowNumber'=>1,
			'columnNumber'=>6,));				
		?>
		</td>
	</tr>
	<tr>
		<td>
		<?php 
			$moreLink = CHtml::link("View More", array("/category/moreView",));
			$moreLink = '<div class="moreLinkForItemDisplay">' .  $moreLink . '</div>';
			$moreLink = '<div style="margin-top: -10px;">' .  $moreLink . '</div>';
			echo $moreLink;
		?>
		</td>
	</tr>
</table>