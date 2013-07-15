<?php

/**
 * This is the model class for table "{{item}}".
 *
 * The followings are the available columns in table '{{item}}':
 * This is the base class for all the follows:
 * 1. item: for sale
 * 2. share: for share
 */
class Goods extends SafeActiveRecord
{
	public $newAttaches = array();
	public $maxAttaches = 4;
	public $summaryLength = 180;	
	public $shortTitleLength = 15;
	public $sortKey = 0;
		
	//weight for search, titleWeight for title
	//                   describeWeight for content
	private $titleWeight = 5;
	private $contentWeight = 1;
	private $tagWeight = 8;
	
	public $viewTimes;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Item the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
		array('title', 'required'),
		array('title', 'length', 'max'=>128 ),
		array('categoryid', 'required'),
		array('conditionid', 'required'),
		array('presentation','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
		array('id, title, create_time, categoryid, conditionid, summary, viewnum, viewTimes', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'user'=>array(self::BELONGS_TO, 'User', 'userid' ),
			'attaches'=>array(self::HAS_MANY, 'Attach', 'itemid' ),
			'comments'=>array(self::HAS_MANY, 'Comment', 'itemid' ),
			'category'=>array(self::BELONGS_TO, 'Category', 'categoryid'),
			'condition'=>array(self::BELONGS_TO, 'Condition', 'conditionid'),
			'status'=>array(self::BELONGS_TO, 'Itemstatus', 'statusid'),
			'tags'=>array(self::HAS_MANY, 'TagItem', 'itemid'),
			'userviews'=>array(self::HAS_MANY, 'Userviewitem', 'itemid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Item ID',
			'userid' => 'Userid',
			'title' => 'Title',
			'presentation' => 'Content',
			'categoryid' => 'Category',
			'conditionid'=>'Condition',
			'propertyName'=>'Properties',
			'tagName'=>'Tags',
			'picName'=>'Pictures',
			'viewTimes'=>'Views',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		//$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('summary',$this->summary,true);
		//$criteria->compare('viewnum',$this->status->viewnum);
		$criteria->compare('userid',$this->userid);	
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->create_time = time();
				//$this->renewThisItem( false );
				$this->expire_time = $this->create_time + Yii::app()->params['expirePeriod'];
				$this->userid=Yii::app()->user->id;
				$tempItemstatus = new Itemstatus();
				$tempItemstatus->save();
				$this->statusid = $tempItemstatus->getPrimaryKey();
			}
			$this->last_modified=time();
			return $this->processContent();
		}
		else
		return false;
	}
	
	private function processContent()
	{
		include_once(Yii::app()->basePath . "/extensions/simplehtmldom/simple_html_dom.php");
		$html_src = str_get_html($this->presentation);
		if ($html_src != null)
		{
			$this->content = $html_src->plaintext;
		} else
		{
			$this->content = "";
		}
		$len = strlen($this->content);
		if ($len > $this->summaryLength)
		{
			$len = $this->summaryLength;
		}
		
		$t = substr($this->content, 0, $len);
		//solve the utf-8 problem, convert it to a valid string
		$t = mb_convert_encoding($t, "UTF-8", "AUTO");
		
		//remove the new line
		$order   = array("\r\n", "\n", "\r");
		$replace = ' ';
		
		// Processes \r\n's first so they aren't converted twice.
		$t = str_replace($order, $replace, $t);
		
		$this->summary = $t." ...";
		return true;
	}

	protected function afterSave()
	{
		
		$this->status->itemid = $this->getPrimaryKey();
		$this->status->save();
		
		parent::afterSave();
	}

	/**
	 * over write beforedelete, to delete the relevent things:
	 * pictures, items
	 */
	protected function beforeDelete()
	{
		if (parent::beforeDelete())
		{
			foreach($this->attaches as $i => $attach)
			{
				if (!$attach->delete())
				{
					return false;
				}
			}
			foreach($this->comments as $i => $comment)
			{
				if (!$comment->delete())
				{
					return false;
				}
			}
			foreach($this->userviews as $i => $userview)
			{
				if (!$userview->delete())
				{
					return false;
				}
			}
			foreach($this->tags as $i => $tag)
			{
				if (!$tag->delete())
				{
					return false;
				}
			}
			$this->status->delete();
			
			return true;
		} else
		return false;
	}

	protected function afterDelete()
	{
		Yii::log("item [id:".$this->getPrimaryKey()."] deleted");
		parent::afterDelete();
	}
	
	public function shortTitle()
	{
		$len = strlen($this->title);
		if ($len>$this->shortTitleLength)
		{
			$len = $this->shortTitleLength;
		}
		$t = substr($this->title, 0, $len);
		//solve the utf-8 problem, convert it to a valid string
		$t = mb_convert_encoding($t, "UTF-8", "AUTO");
		$t .= "...";
		return($t);
	}
	
	public function renewThisItem() {
		if ($this->conditionid == Yii::app()->params['categorySold']) return null;
		if ($this->conditionid == Yii::app()->params['conditionExpired']) {
			$this->conditionid = $this->conditionbackup;
		}		
		$this->expire_time = time() + Yii::app()->params['expirePeriod'];
		$this->save(false, array("conditionid", "expire_time", "last_modified") );	
		Yii::log("item [id:".$this->getPrimaryKey()."] renewed");		
		return("Item renewed successfully, expire time: " . date('Y-m-d',$this->expire_time));
	}
	
	public function markAsSoldThisItem() {
		$this->conditionid = Yii::app()->params['categorySold'];
		$this->save(false, array("conditionid", "last_modified"));
		Yii::log("item [id:".$this->getPrimaryKey()."] marked as sold");
		return("Item marked as sold");
	}
	
	/**
	* The function used to search some items with the
	* criteria described by keyClass
	* @param MODEL::SearchKeysForm $keyClass
	* @return Array
	*/
	public function searchItems($keyClass) {
		//echo "key special is: " . $keyClass->specialAction;
		
		if ($keyClass->specialAction===Yii::app()->params['specialAction_null']) {
			$items = $this->searchCategoryAndCondition($keyClass);
			$items = $this->searchByKeys($keyClass, $items);
		}
		if ($keyClass->specialAction===Yii::app()->params['specialAction_view']) $items = Userviewitem::model()->searchItemsForUser();
		if ($keyClass->specialAction===Yii::app()->params['specialAction_commented']) $items = Comment::model()->searchItemsForUser();
		
		return($items);
	}
	
	/**
	 * Call the search function and turn array to CActiveDataProvider
	 * @param SearchKeysForm $keyClass
	 * @param int $pageSize, default=10
	 * @return CArrayDataProvider
	 */
	public function searchItems_DataProvider($keyClass, $pageSize=10)
	{
		$data = $this->searchItems($keyClass);
		$dataProvider = new CArrayDataProvider( $data,
			array('pagination'=>array('pageSize'=>$pageSize)) );
		return($dataProvider);
	}
	
	public function searchCategoryAndCondition($keyClass) {
		
		$fullStringCtgCdt = "(1=1)";
		$ctg = $keyClass->categoryid;
		$condition = $keyClass->conditionid;
		$userid = $keyClass->userid;
		
		if ($ctg != Yii::app()->params['categoryBaseSet']) {
			$categoryString = Category::model()->getSearchCriteriaById($ctg);
			$fullStringCtgCdt .= " AND ".$categoryString;
		}
		if ($condition != Yii::app()->params['conditionBaseSet']) {
			$conditionString = Condition::model()->getSearchCriteriaById($condition);
			$fullStringCtgCdt .= " AND ".$conditionString;
		}
		if ($userid != null && $userid != 0) {
			$fullStringCtgCdt .= " AND `userid`=$userid ";
		}
		if ($keyClass->timeStart != null) {
			$fullStringCtgCdt .= " AND `create_time` >= $keyClass->timeStart ";
		}
		if ($keyClass->timeStop != null) {
			$fullStringCtgCdt .= " AND `create_time` <= $keyClass->timeStop ";
		}
		
		
		//criteria for search 
		$criteria=new CDbCriteria;
		$criteria->select='*';
		$criteria->condition = $fullStringCtgCdt;		
			
		$criteria->order="create_time DESC";
		$items=Item::model()->findAll($criteria);
		
		return($items);
	}
	
	public function searchByKeys($keyClass, $items)
	{		
		$keys = $keyClass->keys;		
		if (count($keys)!=0) {
			foreach ($items as $i => $item) {
				foreach ($keys as $key)
				{				
					$inTitle = stripos($item->title, $key);
					$inContent = stripos($item->content, $key);
					$inTag = stripos($item->tagString, $key);
					
					if ($inTitle !== false) $item->sortKey += $this->titleWeight;
					if ($inContent !== false) $item->sortKey += $this->contentWeight;
					if ($inTag !== false) $item->sortKey += $this->tagWeight;
				}
			}

			foreach($items as $i => &$item) {
				if ($item->sortKey <= $this->contentWeight) {
					unset($items[$i]);
				}
			}
			
			function sortItemBySortKey($a, $b) {
				return $b->sortKey-$a->sortKey;
			}
			
			usort($items, 'sortItemBySortKey');
		}		

		return($items);
	}
	
}
