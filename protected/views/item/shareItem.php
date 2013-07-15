<!-- AddThis Button BEGIN -->
<?php 
	$this->image_forShare = $item->getSafeFirstPicUrl();
	$this->description_forShare = $item->summary;
	$this->title_forShare = "ITEM: " . $item->title . " [ZLOOP]";
?>

<div class="addthis_toolbox addthis_default_style addthis_32x32_style" >
<script type="text/javascript">
var addthis_config =
{
	ui_delay : 500,
	ui_open_windows : true,
	services_compact : "renren, more",
	services_custom : 
		{name: "Renren",
		url: "http://share.renren.com/share/buttonshare?link={{URL}}&title={{TITLE}}",
		icon: "http://a.xnimg.cn/imgpro/share/share-tinybtn.png"},	
}

var addthis_share =
{
	url : "<?php echo $item->getFullAndSafeUrl();?>", 
	title : "<?php echo "ITEM: " . $item->title . " [ZLOOP]"; ?>",
	description : "<?php echo $item->summary; ?>",
}
</script>
	<a class="addthis_button_facebook"></a>
	<a class="addthis_button_twitter"></a>
	<a class="addthis_button_sinaweibo"></a>
	<a class="addthis_button_compact"></a>

	<!-- <a href="http://www.addthis.com/bookmark.php" class="addthis_button"></a>  -->
	<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f4cdddb15a93392"></script>
<!-- AddThis Button END -->

<div class="itemInstruction">
<h3>How to get it?</h3>
<ol>
	<li>Leave a message below</li>
	<li>Make a deal with seller</li>
	<li>Trade face-to-face</li>
</ol>
</div>