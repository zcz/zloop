<?php

/**
 * This is the model class for pictures, extends "{{attach}}".
 */
class Pic extends Attach
{
	public $largeSize = 800.0;
	public $smallSize = 300.0;
	private $tempName = null;

	public function rules()
	{
		return array(
			array("data", 'file', 'allowEmpty'=>true, 'types'=>'jpg,gif,png', 'maxSize'=>1024*1024*10, ),
			array('id, itemid', 'safe'),
			array('story', 'type', 'type'=>'string', 'allowEmpty'=>true),
		);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function attributeLabels()
	{
		return array(
			'id' => 'error ID',
			'itemid' => 'error Itemid',
			'data' => 'Upload:',
			'isDelete' => 'Delete:',
			'story'=>'Picture description:'
		);
	}
	
	public function getUserPic($model) {
		$picc = $model->profilePic;
		if ($picc != null) {
			return $picc->getSmallUrl();
		} else {
			return "/images/defaultUserSmall_z.jpg";
		}
	}
	
	public function getUserLargePic($model) {
		$picc = $model->profilePic;
		if ($picc != null) {
			return $picc->getLargeUrl();
		} else {
			return "/images/defaultUserSmall_z.jpg";
		}
	}
	
	public function getJSON() 
	{
		$this->data = ""; $this->icon = "";
		return CJSON::encode($this);
	}
	
	public function getUri() 
	{
		return Yii::app()->createUrl('api/pic/' . $this->id );
	}

	public function getUrl()
	{
		return Yii::app()->createUrl('pic/view', array(
				'id'=>$this->id, ));
	}
	
	public function getFullUrl()
	{
		return Yii::app()->createAbsoluteUrl('pic/view', array('id'=>$this->id, ));
	}
	
	
	public function getLogoUrl()
	{
		$url = Yii::app()->createAbsoluteUrl("");
		$url = str_replace("index.php", "images/logo.jpg", $url);
		return($url);
	}
	
	public function getSmallLogoUrl()
	{
		$url = Yii::app()->createAbsoluteUrl("");
		$url = str_replace("index.php", "images/logo_small.jpg", $url);
		return($url);
	}
	
	public function getSmallUrl()
	{
		return Yii::app()->createUrl('pic/viewSmall', array(
				'id'=>$this->id, ));
	}
	
	public function getSafeSmallUrl() {
		return parent::getFullAndSafeUrl( 'pic/viewSmall', array('id'=>$this->id, ));
	}
	
	public function getLargeUrl()
	{
		return Yii::app()->createUrl('pic/viewLarge', array(
				'id'=>$this->id, ));
	}
	
	public function getDefaultPicUrl()
	{
		return "./images/square_logo.png";
	}
	
	public function getSafeDefaultPicUrl() {
		$s =  parent::getFullAndSafeUrl();
		$findIt = "/index.php/";
		$replace = "/images/square_logo.png";
		$s = preg_replace($findIt, $replace, $s, 1);
		return($s);
	}
		
	/**
	 * over write before save, load file
	 */
	public function beforeSave()
	{
		if (parent::beforeSave())
		{
			$this->last_modified = time();
			if ($this->isNewRecord)
			{
				Yii::log("new pic uploaded and processed.");
				if ($this->data!=null)
				{
					$this->resizefile();
					return true;
				}
				else
				{
					Yii::log("process pic failed with data = null", "error");
					Yii::log("process pic failed with data = null");
					return false;
				}
			} else
			{
				return true;
			}
		}
		else
		{
			Yii::log("process pic failed with parent save = null", "error");
			Yii::log("process pic failed with parent save = null");
			return (false);
		}
	}
	
	private function scalePicture( $w, $h, $total, &$ww, &$hh ) {
		$ww = $w;
		$hh = $h;
		if ($ww + $hh > $total) {
			$tt = $ww + $hh;
			$ww = $ww * 1.0 * ($total/$tt);
			$hh = $hh * 1.0 * ($total/$tt);
		}
	}
	
	private function resizefile()
	{
		$src = imagecreatefromstring($this->data);
		
		//get x and y from one picture
		$w = imagesx($src);
		$h = imagesy($src);
		
		//calculate the large picture size, data
		$this->scalePicture($w, $h, $this->largeSize, $lw, $lh);
				
		//calculate the small picture size, icon
		$this->scalePicture($w, $h, $this->smallSize, $sw, $sh);
		
		//get a "empty" picture from the new size
		$large_pic = imagecreatetruecolor($lw, $lh);
		$small_pic = imagecreatetruecolor($sw, $sh);
		
		//resize picture
		imagecopyresized( $large_pic , $src , 0 , 0 , 0 , 0, $lw , $lh , $w , $h );
		imagecopyresized( $small_pic , $src , 0 , 0 , 0 , 0, $sw , $sh , $w , $h );

		//store the resize results
		imagealphablending($large_pic, TRUE);
		imagesavealpha($large_pic, TRUE);
		imagealphablending($small_pic, TRUE);
		imagesavealpha($small_pic, TRUE);
		
		//save content to database
		ob_start();
		imagejpeg($large_pic, null, 100);
		$this->data = ob_get_contents();
		ob_end_clean();

		ob_start();
		imagejpeg($small_pic, null, 100);
		$this->icon = ob_get_contents();
		ob_end_clean();

		//save to file, may not needed, just for test
		//imagejpeg($large_pic, "images/large.jpg");
		//imagejpeg($small_pic, "images/small.jpg");
		
		imagedestroy($src);
		imagedestroy($large_pic);
		imagedestroy($small_pic);
		
	}

}