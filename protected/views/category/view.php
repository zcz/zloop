<?php
//$links = $model->getPathBreadCrumbs();
//$this->breadcrumbs=$links;
?>


<table>
	<tr>
		<?php 
			echo '<td valign="top" style="padding-top:4px; width=194px">';
			//not change category bar, leave it at the to level
			//$this->widget('CategoryNavigation', array('categoryId'=>$model->id));
			$this->widget('CategoryNavigation');
			echo '</td>';
		?>
		<td valign="top" align="left" width=100%>	
			<?php 
			
			$content  = "";
			$content .= $this->widget("ItemDisplayWidget", array("isBar"=>false, 'categoryId'=>$model->id), true);
			
			$moreLink = CHtml::link("More", array("/category/moreView", 'id'=>$model->id));
			$moreLink = '<div class="moreLinkForItemDisplay">' .  $moreLink . '</div>';
			
			$this->widget("DisplayBox",
			array(
				'title' => $this->widget('zii.widgets.CBreadcrumbs', array('links'=>$model->getPathBreadCrumbs(),), true),
				'moreLink' => $moreLink,
				'content' => $content . $moreLink,
				'withSpaceAround' => false,
				'withSpaceTopBottom' => false,
			));
			
			?>	
		</td><!-- content -->
	</tr>
</table>