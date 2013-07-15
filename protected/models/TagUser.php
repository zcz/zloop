<?php 
/**
 * This is the model class for table "{{tagUser}}".
 */
class TagUser extends TagBase
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
		return '{{tagUser}}';
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
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'basetag'=>array(self::BELONGS_TO, 'Tag', 'tagid' ),
		);
	}
	
	public function fetchTagUser( $tag )
	{
		$uid = Yii::app()->user->id;
		if ($uid == null) return null;
		
		$tagsOld = TagUser::model()->find(
			"tagid = :tagid AND userid = :userid", 
			array(
				":tagid"=>$tag->getPrimaryKey(), 
				":userid"=>$uid
			)
		);
		
		if ($tagsOld == null)
		{
			$tagNew = new TagUser;
			$tagNew->tagid = $tag->getPrimaryKey();
			$tagNew->userid = $uid;
			$tagNew->save();
		}
		else
		{
			$tagNew = $tagsOld;
		}		
		
		return($tagNew);

	}
	
	public function getTagUserList($selected, &$selectList)
	{
		$uid = Yii::app()->user->id;
		if ($uid == null) return array();
		$selectList = array();
		
		$list = array();
		
		$tags = TagUser::model()->findAll("userid = :userid", 
										  array(":userid"=>$uid));
		foreach($tags as $tag)
		{
			$t = $tag->basetag;
			$list[$t->id] = $t->tagName;
			if (isset($selected[$t->id]))
			{
				$selectList[$t->id] = array('selected'=>'selected');
			}
		}
		$list[""]='';
		return($list);
	}
	
	public function updateUsed($tagid)
	{
		$uid = Yii::app()->user->id;
		
		if (($uid == null)||($uid == 0))
		{
			return null;
		}
		$tag = TagUser::model()->find("userid = :userid AND tagid = :tagid",
			array(":userid"=>$uid, ':tagid'=>$tagid));
		if ($tag != null)
		{
			$tag->numused++;
			$tag->save();
		}
	}
	
	public function updateView($tagid)
	{
		$uid = Yii::app()->user->id;
		if ($uid == null || $uid == 0) return null;
		$tag = TagUser::model()->find("userid = :userid AND tagid = :tagid",
			array(":userid"=>$uid, ':tagid'=>$tagid));
		if ($tag != null)
		{
			$tag->numview++;
			$tag->save();
		}
	}
		
}