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
	
	if ($i == 0)
	{
		$widthIs = 150;
	} else {
		$widthIs = 50;
		$border = $i;
	}
	
	$picIs[$i] = CHtml::link(
		CHtml::image(
			$smallUrl,
			$pic->item->title,    //title of picture
			array("width"=>"$widthIs")),
		$largeUrl,
		array("title"=>$pic->story, "rel"=>"prettyPhoto[gallery1]" )
	);
echo "  ";
}
$this->endWidget("PrettyPhoto");
?>

<table width="100%" border=<?php echo $border;?> >
	<tr>
		<td><div align="center">
				<?php  
					$i = 0; 
					if (isset($picIs[$i])) 
					{
						echo $picIs[$i++]; 
					}
				?>
			</div></td>
	</tr>
	<tr> 
		<td><table width="100%" border="0">
				<tr>
					<td>
						<?php if (isset($picIs[$i])) echo $picIs[$i++];?>
					</td>
					<td>
						<?php if (isset($picIs[$i])) echo $picIs[$i++];?>
					</td>
					<td>
						<?php if (isset($picIs[$i])) echo $picIs[$i++];?>
					</td>
				</tr>
			</table></td>
	</tr>
</table>


