<?php

/**
 * This part is dropped, replaced by GD image processing
 * 

Yii::import('application.extensions.imageResize.drivers.GD');
$pic = $pics[0];
$url = $pic->getUrl();

echo $url;

$image = Yii::app()->image->load("images/test.jpg");
$image->resize(400, 100);
$image->save('images/small2.jpg');
**/

//test by load a picture from database
$pic = $pics[0];
//form a GB type from pure data
$old = imagecreatefromstring($pic->data);

$src = $old;

//get x and y from one picture
$w = imagesx($old);
$h = imagesy($old);

echo ($w." ".$h);

//the resize percentage
$percent = 0.3;

//calculate the new picture size
$nw = $w * $percent;
$nh = $h * $percent;

//get a "empty" picture from the new size
$des = imagecreatetruecolor($nw, $nh);

//resize picture
if(imagecopyresized( $des , $src , 0 , 0 , 0 , 0, $nw , $nh , $w , $h ))
{
	//store the resize results
	imagealphablending($des, TRUE);
	imagesavealpha($des, TRUE);

	//save content to database
	ob_start();
	imagejpeg($des, null, 2);  //2 should be changed to 100;
	$obImageData = ob_get_contents();
	ob_end_clean();

	//save to file, may not needed
	imagejpeg($des, "images/small2.jpg");
	$for_db = imagecreatefromstring($obImageData);
	imagejpeg($for_db, "images/db.jpg");
}
else
{
	//log for error
	log("image resize fail", "error" );
}


