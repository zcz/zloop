<script type="text/javascript">
function selectPic(s)
{
	var li = s;
	var im = li.getElementsByTagName("img").item(0);
	var bigPic = document.getElementById('show-picture');
	var picList = document.getElementById('picList');
	 
	for (var i=0;i<picList.getElementsByTagName("li").length;i++)
	{
		var picListItem = picList.getElementsByTagName("li").item(i);
		picListItem.className="";
	}
	bigPic.src = im.src;
	
	li.className="pic-selected";
	}
</script>

<?php

Yii::import("application.extensions.prettyPhoto.PrettyPhoto");

$this->beginWidget("PrettyPhoto", array(
  'id'=>'pretty_photo',
  // prettyPhoto options
  'options'=>array(
    'opacity'=>0.80,
    'modal'=>false,
    'hideflash'=>false,   
)
));

$border = 0;
$picIs = array();

foreach ($pics as $i=>$pic)
{
	$largeUrl = $pic->getLargeUrl();
	$smallUrl = $pic->getSmallUrl();
	
	$picIs[$i] = CHtml::link(
		CHtml::image(
			$largeUrl,
			$pic->item->title   //title of picture
		),
		$largeUrl,
		array("title"=>$pic->story, "rel"=>"prettyPhoto[gallery1]" )
	);
}

if (isset($pics[0]))
{
	$largeUrl = $pics[0]->getLargeUrl();
	
	$BigPic = CHtml::image(
		$largeUrl,
		$pic->item->title,   //title of picture
		array('id'=>"show-picture")
	);
} else
{
	$smallUrl = Pic::model()->getDefaultPicUrl();
	
	$BigPic = CHtml::image(
		$smallUrl,
		"default",   //title of picture
		array('id'=>"show-picture")
	);
}
?>


<div class="pic-cell">
	<div class="big-pic">
		<?php  

			if (isset($BigPic)) 
			{
				echo $BigPic; 
			}
		?>
	</div>
	<ul class="pic-list" id="picList">
		<?php 
			$i = 0;
			while (isset($picIs[$i])) 
			{
				if ($i==0) $classIs = 'class="pic-selected"';
				else $classIs = "";
				echo '<li ' . $classIs . 'onmouseover="selectPic(this);">';
				echo '<div class="small-pic">';
				echo $picIs[$i++];
				echo '</div>';
				echo '</li>';
				
			}
		?>		
	</ul>
</div>

<?php 
$this->endWidget("PrettyPhoto");
?>