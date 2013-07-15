
<script type="text/javascript">
function show_confirm_mark_as_sold(s)
{
	var r=confirm("Mark as sold is not reversible.\nAre you sure you want to continue?");
	if (r==true){
		//alert(s);
		window.location = s;
	}
}
</script>

<?php echo $this->renderPartial('/pic/viewPrettyphoto',array('pics'=>$item->pictures)); ?>
			
<div class="info-cell">
	<table class="info-table">
		<tr>
			<td colspan="4">
				<span class="item-title"><?php echo $item->title?></span>
				<div style="float:right;">
					<div style="float:left;">
						<?php 
							$editUrl = $item->getUrlForRenewItem();
							if (isset(Yii::app()->user->id) && Yii::app()->user->id == $item->userid) {
								if ($item->conditionid != Yii::app()->params['categorySold']) {
									echo '<input type="button" onClick="location.href=\''. $editUrl .'\'" value="Renew" />';
								}
							}
						?>
					</div>
					<div style="float:left;">
						<?php 
							$editUrl = $item->getUrlForEdit();
							if (isset(Yii::app()->user->id) && Yii::app()->user->id == $item->userid) {
								if ($item->conditionid != Yii::app()->params['categorySold']) {
									echo '<input type="button" onClick="location.href=\''. $editUrl .'\'" value="Edit" />';	
								}
							}
						?>
					</div>
					<div style="float:right;"> 
						<?php 
	
							if (isset(Yii::app()->user->id) && Yii::app()->user->id == $item->userid)
							{
								if ($item->conditionid != Yii::app()->params['categorySold'] && $item->conditionid != Yii::app()->params['conditionExpired'])
								{
									$url = $item->getUrlForMarkAsSoldOut();
									//echo "<a href=".$url.">Mark As Sold<a>";
									$paraUrl = 'show_confirm_mark_as_sold("'.$url.'")';
									//$paraUrl = 'show_confirm_mark_as_sold(String("haah"))';
									echo '<input type="button" onclick='.$paraUrl.' value="Mark As Sold" />';
								}
							} else {
								/* stop devemopping appointment function
								if ($item->conditionid != Yii::app()->params['categorySold']) {
									$appointmentURL = $item->getAppointmentUrl();
									echo '<input type="button" onClick="location.href=\''. $appointmentURL .'\'" value="Make An Appointment" />';
								}
								*/
							}
														
						?>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<th class="item-detail-label">Owner:</th>
			<td colspan="3" class="item-detail-value">
				<span class="item-detail-text">
					<a href=""><b><?php echo $item->user->getNameLink(); ?></b></a>
				</span>
			</td>
		</tr>
		<tr>
			<th class="item-detail-label">Price:</th>
			<td colspan="3" class="item-detail-value">
				<span class="item-detail-text">
					<span class="item-detail-text-price"><?php echo $item->pricelow; ?></span>
					&nbsp;to&nbsp;
					<span class="item-detail-text-price"><?php echo $item->pricehigh; ?></span>
					&nbsp;HKD
				</span>
			</td>
		</tr>
		<tr>
			<th class="item-detail-label">Item condition:</th>
			<td colspan="3" class="item-detail-value">
				<span class="item-detail-text">
					<b>
					<?php
					
						$conditionText = $item->condition->title;
					
						if ($item->conditionid == Yii::app()->params['categorySold'] || $item->conditionid == Yii::app()->params['conditionExpired']) {
							$conditionText = "<span style=\"color: rgb(255, 102, 0);\">$conditionText</span>";
						}
						echo $conditionText;
					?></b>
				</span>
			</td>
		</tr>
		<tr>
			<th class="item-detail-label">Category:</th>
			<td colspan="3" class="item-detail-value">
				<span class="item-detail-text">
					<a href=<?php echo $item->category->getUrl(); ?>><?php echo $item->category->title; ?></a>
				</span>
			</td>
		</tr>
		<tr>
			<th class="item-detail-label">Created on:</th>
			<td colspan="3" class="item-detail-value">
				<span class="item-detail-text">
					<?php echo date('Y-m-d',$item->create_time); ?>
				</span>
			</td>
		</tr>
		
		<tr>
			<th class="item-detail-label">Expire on:</th>
			<td colspan="3" class="item-detail-value">
				<span class="item-detail-text">
					<?php echo date('Y-m-d',$item->expire_time); ?>
				</span>
			</td>
		</tr>
<!-- 		
		<tr>
			<th class="item-detail-label">Tags:</th>
			<td colspan="3" class="item-detail-value">
				<span class="item-detail-text">
					<?php echo $item->tagString; ?>
				</span>
			</td>
		</tr>
 -->
		<tr>
			<th class="item-detail-label">Views:</th>
			<td colspan="3" class="item-detail-value">
				<span class="item-detail-text">
					<?php echo $item->status->viewnum;  ?>
				</span>
			</td>
		</tr>
	</table>
</div>

<div class = "shareInfo-cell" >

<?php 
$this->widget("DisplayBox",
array(
		'title' => "Share it:",
		'content' => $this->renderPartial("/item/newShareItem", array('item'=>$item), true),
		'withSpaceAround' => false,
));
?>

</div>

<div class = "clearAllDiv" ></div>
