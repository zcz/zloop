<?php

/**
 * This is the model class for table "{{tag}}".
 */
class Tag extends TagBase
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
		return '{{tag}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tagName', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'users'=>array(self::HAS_MANY, 'TagUser', 'tagid' ),
			'items'=>array(self::HAS_MANY, 'TagItem', 'tagid' ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tagName'=>'Tags',
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

		$criteria->compare('tagName',$this->tagName,true);
		$criteria->compare('numused',$this->numused);
		$criteria->compare('numview',$this->numview);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function fetchTagByName($s)
	{
		$tagsOld = Tag::model()->find("tagname = :tagName", array(":tagName"=>$s));
		
		if ($tagsOld == null)
		{
			$tag = new Tag;
			$tag->tagName = $s;
			$tag->create_time = time();
			$tag->save();
		}
		else
		{
			$tag = $tagsOld;
		}		
		return($tag);
	}
	
	public function processNewTag($tagString, &$selected)
	{
		$replaceFrom = array(",", ".", "?", "/", "\\", "!", "@", "|", "(", ")", "，", "。");
		$replaceTo = " ";
		$tagString = str_replace($replaceFrom, $replaceTo, $tagString);
		$arrayString = explode($replaceTo, $tagString);
		
		foreach($arrayString as $i=>$s)
		{
			if ($s != "")
			{
				$tag = Tag::model()->fetchTagByName($s);
				$tagMe = TagUser::model()->fetchTagUser($tag);
		
				$selected[$tag->id] = $tagMe->numused;
			}
		}
	}
	
	public function newItemTags( $item, $selected )
	{
		$itemid = $item->getPrimaryKey();
		$string = "";
		
		foreach($item->tags as $tag)
		{
			if (!isset($selected[$tag->tagid]))
			{
				$tag->delete();
			}
		}
				
		foreach ($selected as $t=>$num)
		{
			$tagid = $t;			
			$tag = TagItem::model()->fetchTagItem($tagid, $itemid);
			$this->updateUsed($t);
			$string .= $tag->basetag->tagName." ";
		}
		
		$item->tagString = $string;
		$item->save();
		return true;
	}
	
	public function updateUsed($tagid)
	{
		$tag = Tag::model()->findByPk($tagid);
		if ($tag != null)
		{
			$tag->numused++;
			$tag->save();
		}
		TagUser::model()->updateUsed($tagid);
	}
	
	public function updateView( $tagitem )
	{
		$tag = $tagitem->basetag;
		if ($tag!=null)
		{
			$tag->numview++;
			$tag->save();
		}
		TagUser::model()->updateView($tagitem->tagid);
	}
	
	
	public function viewItem( $item )
	{
		$tagsOfItem = TagItem::model()->findAll("itemid=:itemid", array(":itemid"=>$item->id));
		
		if ($tagsOfItem != null)
		{			
			foreach ($tagsOfItem as $tagitem)
			{
				$this->updateView($tagitem);
			}
		} 
	}
	
	public function beforeDelete()
	{
		if (parent::beforeDelete())
		{
			foreach($this->items as $tagitem)
			{
				if (!$tagitem->delete())
				{
					return false;
				}
			}
			foreach($this->users as $taguser)
			{
				if (!$taguser->delete())
				{
					return false;
				}
			}
			return true;
		} else
		return false;
	}

}