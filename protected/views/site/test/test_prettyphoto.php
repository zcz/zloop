<?php

Yii::import("application.extensions.prettyPhoto.PrettyPhoto");


$this->beginWidget("PrettyPhoto", array(
  'id'=>'pretty_photo',
  // prettyPhoto options
  'options'=>array(
    'opacity'=>0.90,
    'modal'=>false,
    'hideflash'=>false,
    
)
));



$cc = 0;

foreach ($pics as $i=>$pic)
{
	++$cc;
	if ($cc === 1)
	{
		$title = "this is title";
	} else
	{
		$title = "";
	}
	$largeUrl = $pic->getLargeUrl();
	$smallUrl = $pic->getSmallUrl();
		
	echo CHtml::link(
		CHtml::image(
			$smallUrl,
			"this is number: ".$i, 
			array("height"=>"90", "width"=>"90")),
		$largeUrl,
		array("title"=>"good?".$title, "rel"=>"prettyPhoto[gallery1]" ));
echo "  ";
}

$this->endWidget("PrettyPhoto");



