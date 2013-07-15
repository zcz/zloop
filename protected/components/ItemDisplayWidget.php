<?php
/**
 * This is the ItemDisplayWidget, it could be bar or table 
 * used at the buttom of page, or on the right side of category display
 * Called from main page.
 * 
 * @author zcz
 */

class ItemDisplayWidget extends CWidget
{
	/**
	 * isBar: 
	 * True: show in a bar view, called from the frontpage from browser other then ie(1-8)
	 * False: show in a table view, the number of rows and columns can be configured
	 */
	public $isBar = false;
	//the total number = row*column, or just a number for the active view
	public $totalItemNumber = 15;
	public $rowNumber = 3;
	public $columnNumber = 5;
	//will be set below
	public $categoryId = 0;
	public $conditionId;
	public $keyString = "";
	public $ownerid = 0;
	public $keyWord;
	public $specialAction ="null";
	public $displayContent = true;
	public $timeStart;
	public $timeStop;
	public $content;
	public $wholeItemList;
	
	public function init() 
	{
		//set default Item category
		$this->conditionId = Yii::app()->params['defaultViewCondition'];
		
		//if ($this->timeStart == null) $this->timeStart = time();
		if ($this->timeStop == null) $this->timeStop = 0;
		
		//decide which view is needed
		//if the browser is ie(1-8) can only display table view, not bar view
		//due to the unsupport of jquery, overwrite the decision of coder
		if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/MSIE ([0-9]\.[0-9])/',$_SERVER['HTTP_USER_AGENT'],$reg))
		{
			if (floatval($reg[1])<9)
			{
				$this->isBar = false;
			}
		}
		
		if (!$this->isBar){
			$this->totalItemNumber = $this->columnNumber * $this->rowNumber;
		}
		
		//defind the search criteria
		$this->keyWord = new SearchKeysForm;
		$this->keyWord->categoryid = $this->categoryId;
		$this->keyWord->conditionid = $this->conditionId;
		$this->keyWord->keyString = $this->keyString;
		$this->keyWord->userid = $this->ownerid;
		$this->keyWord->specialAction = $this->specialAction;
		$this->keyWord->timeStart = $this->timeStart;
		$this->keyWord->timeStop = $this->timeStop;
	}
	
	public function retrieveData() {
		$this->wholeItemList = Goods::model()->searchItems($this->keyWord);
		return($this->wholeItemList);
	}
	
	public function run() 
	{
		//retreive the data from Good model
		$list = $this->retrieveData();
		$list = array_slice($list, 0, $this->totalItemNumber);
		$this->content = "";
		if ($this->isBar) {
			$this->content = $this->renderBar($list);
		} else 	{
			$this->content = $this->renderTable($list);
		}
		if ($this->displayContent == true) {
			echo $this->content;
		} else {
			return($this->content);
		}
	}
	
	public function renderBar($list)
	{
		$s = "";
		$s .= '<link href="' . Yii::app()->request->baseUrl . '/css/jCarousel.css" rel="stylesheet" type="text/css" />';	
		//$s .= '<link rel="stylesheet" type="text/css" href="' . Yii::app()->request->baseUrl . '/css/myZloop.css" />';
		//$s .= '<script type="text/javascript" src="'.Yii::app()->request->baseUrl.'/protected/extensions/jQuery/jquery-1.6.1.min.js"></script>';
		$s .= '<script type="text/javascript" src="'.Yii::app()->request->baseUrl.'/protected/extensions/jQuery/showItem/jquery.jcarousel.min.js"></script>';
		$s .= '<script type="text/javascript">';
		$s .= 'jQuery(document).ready(function() {jQuery("#mycarousel").jcarousel();}); ';
		$s .= '</script>';
		
		$s .= '<ul id="mycarousel" class="jcarousel-skin-tango">';
		foreach ($list as $i=>$item)
		{
			$s .= '<li>';
			$s .= $this->renderItem_div($item);
			$s .= '</li>';
		}
		$s .= '</ul>';
		
		return($s);
	}
	
	public function renderTable($list)
	{
		$s  = "";
		$s .= '<table id="showItem_IE">';
		
		while(count($list)!=0)
		{
			$subList = array_slice($list, 0, $this->columnNumber );
			$list = array_slice($list, $this->columnNumber );
			
			$s .= '<tr>';
			$s .= $this->renderOneRow($subList);
			$s .= '</tr>';
		}
		
		$s .= '</table>';
		return ($s);
		
	}
	
	public function renderOneRow($items)
	{
		$s = "";
		foreach ($items as $i => $item)
		{
			$s .= '<td>';
			$s .= $this->renderItem_div($item);
			$s .= '</td>';
		}
		//$s .= '<td width=100%></td>';
		return($s);
	}
	
	public function renderItem_div($item)
	{
		//more restrict need to be added to the title and description
		$s  = "";
		$s .= '<div class = "itemContainer">';
		$s .= 	'<div class = "itemPicture">' . $item->getFirstPicLink() . '</div>';
		$s .= 	'<div class = "itemPrice">' . $item->getPrice() . '</div>';
		$s .= 	'<div class = "itemTitle">' . $item->getTitleLink() . '</div>';
		$s .= 	'<div class = "clearAllDiv"></div>';
		$s .= '</div>';
		return ($s);
	}
	
}
