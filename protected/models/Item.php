<?php

/**
 * This is the model class for table "{{item}}".
 * and also for sales, may have
 * 1. regular
 * 2. auction
 * 3. firstClick buy
 */
class Item extends Goods
{
	public $maxPics = 4;

	/**
	 * Returns the static model of the specified AR class.
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function rules()
	{
		$a = parent::rules();
		array_push($a, array("pricelow", 'compare', 'operator'=>'>=', 'compareValue'=>0));
		array_push($a, array("pricehigh", 'compare', 'operator'=>'<=', 'compareValue'=>1000000000));
		array_push($a, array("pricelow", 'compare', 'operator'=>'<=', 'compareAttribute'=>'pricehigh'));
		return($a);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$a = parent::relations();
		$a['pictures']=array(self::HAS_MANY, 'Pic', 'itemid' );
		return($a);
	}
	
	public function attributeLabels()
	{
		$a = parent::attributeLabels();
		$a["price"]='Price';
		return($a);
	}
	
	public function ifPicFull() {
		if ($this->pictures != null) {
			if (count($this->pictures) < $this->maxPics) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	public function getJSON() {
		$s = CJSON::decode(CJSON::encode($this));
		$pics = array();
		foreach($this->pictures as $i => $attach) {
			$pic = array();
			$pic['uri'] = $attach->getUri();
			$pics[] = $pic;
		}
		$s['pics'] = $pics;
		return CJSON::encode($s);
	}

	public function getUri() {
		return Yii::app()->createUrl('api/item/' . $this->id );
	}
	
	public function getUrl() {
		//return Yii::app()->createUrl('item/view', array( 'id'=>$this->id, ));
		return parent::getFullAndSafeUrl('item/view', array('id'=>$this->id, ));
	}
		
	public function getAbsoluteUrl() {
		return Yii::app()->createAbsoluteUrl('item/view', array(
	        		'id'=>$this->id,
		));
	}
	
	public function getUrlForEdit() {
		return Yii::app()->createUrl('item/update', array(
	        		'id'=>$this->id, ));
	}
	
	public function getAppointmentUrl() {
		return Yii::app()->createUrl( 'appointment/create', array('itemid'=>$this->id));
	}
	
	public function getFullAndSafeUrl() {
		return(parent::getFullAndSafeUrl("item/view", array("id"=>$this->id)));
	}
	
	public function getUrlForMarkAsSoldOut(){
		return parent::getFullAndSafeUrl('item/markAsSold', array('id'=>$this->id, ));
	}
	
	public function getUrlForRenewItem() {
		return parent::getFullAndSafeUrl('item/renewItem', array('id'=>$this->id, ));
	}
	
	public function getGeneralLink( $s, $htmlArray = array() ) {
		$linkString = CHtml::link( $s , array('/item/view', 'id'=>$this->id), $htmlArray);
		return($linkString);
	}
	
	public function getTitleLink()
	{
		$linkString = CHtml::link(CHtml::encode($this->title), $this->getUrl());
		return($linkString);
	}
	
	public function getTitleLinkWithCss()
	{
		$linkString = CHtml::link(CHtml::encode($this->title), $this->getUrl(), array("style"=>"padding-top: 3px;text-decoration: none;font-size: 15px;"));
		return($linkString);
	}
	
	public function getShortTitleLink()
	{
		$linkString = CHtml::link(CHtml::encode($this->shortTitle()), array('/item/view', 'id'=>$this->id));
		return($linkString);
	}
	
	public function getShortTitleBold()
	{
		$text = "<b>".CHtml::encode($this->shortTitle())."</b>";
		return($text);
	}
	
	public function getPrice() {
		$low = intval($this->pricelow);
		$high = intval($this->pricehigh);
		if ($low == 0 && $high == 0) return ( "free" );
		$high = '$' . $high;
		if ($low == 0) return( "free to " . $high);
		$low = '$' . $low;
		if ($low == $high) return( $low );
		return( $low . " to " . $high );
	}
	
	public function getSafeFirstPicUrl() {
		if ($this->pictures != null) {
			return $this->pictures[0]->getSafeSmallUrl();
		} else {
			return Pic::model()->getSafeDefaultPicUrl();
		}
	}
	
	public function getFirstPicUrl() {
		return( $this->getSafeFirstPicUrl() );
	}
	
	public function getFirstPicLink()
	{
		$s = "";
		$s = '<a href='.$this->getUrl().'><img src='.$this->getFirstPicUrl().'></a>';
		return($s);
	}
	
	public function getFirstPicLinkWithCss()
	{
		$s = "";
		$s = '<a href='.$this->getUrl().'><img style="	
			margin-top: 5px;
			max-width:120px; 
		    min-height:126px;
		    max-height:126px;"
			src='.$this->getFirstPicUrl().'></a>';
		return($s);
	}

	public function getPathBreadCrumbs()
	{
		$a = $this->category->getPathBreadCrumbs();
		array_push($a, $this->title);
		return($a);
	}
	
	//return the comments that waiting for reply
	public function notification($uid)
	{
		$criteria=new CDbCriteria;
		$criteria->condition="userid = :userid";
		$criteria->params = array(":userid"=>"$uid");
		
		$items = $this->findAll($criteria);
		
		$returnArray = array();

		if ($items != null)
		{
			foreach ($items as $i => $item)
			{
				foreach ($item->comments as $o => $comment)
				{
					if ($comment->reply_time == 0)
					{
						array_push($returnArray, $comment );
					}
				}
			}
		}		
		return($returnArray);
	}
}
