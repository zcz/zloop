<?php 
/**
 * This is the model class for table "{{tagUser}}".
 */
class TagItem extends TagBase
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Tag the static model class
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
		return '{{tagItem}}';
	}
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('tagid', 'safe'),
		);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'basetag'=>array(self::BELONGS_TO, 'Tag', 'tagid' ),
			'baseitem'=>array(self::BELONGS_TO, 'Item', 'itemid'),
		);
	}

	public function loadTags($item)
	{
		$selected = array();
		$tags = $this->findAll("itemid = :itemid", array(":itemid"=>$item->id));
		foreach ($tags as $i=>$t)
		{
			$selected[$t->tagid] = 0;
		}
		return($selected);
	}
	
	public function fetchTagItem( $tagid, $itemid )
	{
		if ($itemid == null || $tagid == null) return null;
		
		$tagsOld = TagItem::model()->find(
			"tagid = :tagid AND itemid = :itemid", 
			array(
				":tagid"=>$tagid, 
				":itemid"=>$itemid
			)
		);
		
		if ($tagsOld == null)
		{
			$tagNew = new TagItem;
			$tagNew->tagid = $tagid;
			$tagNew->itemid = $itemid;
			$tagNew->save();
		}
		else
		{
			$tagNew = $tagsOld;
		}		
		return($tagNew);
	}
}