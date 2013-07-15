<div id = 'currentPics'><?php $this->renderPartial("/pic/showItemPics", array("item"=>$item));?></div>
<div id = 'fileUpload'>
<?php 
$this->widget("DisplayBox", array(
		'title' => "Upload a picture:",
		'content' => $this->renderPartial("/pic/uploadFile", array("pic"=>$pic), true),
		'withSpaceAround' => false,
));
?></div>
<div id = 'googlePic'>
<?php
$this->widget("DisplayBox", array(
		'title' => "Pictures from Google:",
		'content' => $this->renderPartial("/pic/googleSearchPic", array('item'=>$item), true),
		'withSpaceAround' => false,
));
?></div>
<div class = "clearAllDiv" ></div>