<?php

/**
 * SearchKeysForm class.
 * SearchKeysForm is the data structure for keeping
 * user input keys. It is used by the 'item' action of 'index' for search.
 */
class SearchKeysForm extends CFormModel
{
	public $categoryid = 0;
	//defind in init 
	public $conditionid;
	public $userid = 0;
	public $keyString = "";
	public $_keys;
	//define in init
	public $specialAction;
	public $timeStart;
	public $timeStop;
	private $maxNumOfKeys = 8;
	
	public function init() {
		
		$this->conditionid = Yii::app()->params['defaultViewCondition'];
		$this->specialAction = Yii::app()->params['specialAction_null'];
		$this->timeStart = 0;
		$this->timeStop = time();
		
		return(parent::init());
	}
	
	public function getKeys()
	{
		$this->_keys = array();
		$token = strtok($this->keyString, " "); 
		$count = 0;
		while ($token !== false && $count < $this->maxNumOfKeys)
		{
			$count++;
			array_push( $this->_keys, $token);
			$token = strtok(" ");
		}
		return $this->_keys;
	}
	
	public function rules()
	{
		return array(array('keyString, categoryid, conditionid', 'safe'),);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'keyString'=>'Search',
			'categoryid' => 'Category',
		);
	}
	

}
