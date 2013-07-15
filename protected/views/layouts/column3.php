<?php $this->beginContent('//layouts/main'); ?>
<?php 
	$mainwidth = 75.0;
	$sidewidth = (100.0-$mainwidth)/2;
?>

<table border='0'>
	<tr>
		<td valign="top" ></td>
		<td width="950px">
			<?php $this->renderPartial('/layouts/parts/header');?>
			
			<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			                        'links'=>$this->breadcrumbs,
			    	)); ?><!-- breadcrumbs -->
			<?php endif?>			
			
			<?php echo $content; ?>
		</td>
		<td></td>
	</tr>
</table>

<?php $this->endContent(); ?>