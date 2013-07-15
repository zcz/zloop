<?php	
	$content = "";

	$content .= $this->renderPartial("/pic/addPicGoogleAndUpload", array("item"=>$item, "pic"=>$pic), true);
	
	$content .= CHtml::link(CHtml::button("Edit Item"), array("item/update", 'id'=>$item->id));
	$content .= "&nbsp;&nbsp;&nbsp;";
	$content .= CHtml::link(CHtml::button('Done', array("name"=>"finishPic")), array('view','id'=>$item->id));

	$this->widget("DisplayBox", array(
		'title' => "add pic for item: $item->title",
		'content' => $content,
		'withSpaceAround' => true,
		'withSpaceTopBottom' => true,
	));
?>

<script type="text/javascript">

function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}
addLoadEvent(function() {

	<?php 	
	if ($pic_upload_failed == true) {
		echo 'window.alert(\'Google Picture load failed, please try again or choose another one!\');';
	}?>
	
});

</script>