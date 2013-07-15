<?php

/**
 * This is the model class for table "{{condition}}".
 *
 * The followings are the available columns in table '{{condition}}':
 * @property integer $id
 * @property string $title
 * @property string $detail
 */
class Condition extends PropertyOfItem
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Condition the static model class
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
		return '{{condition}}';
	}
	
	public function foreignKey()
	{
		return 'conditionid';
	}
	
	/**
	 * this version is different from properties, 
	 * because it is easier to use this version.
	 * @return array relational rules.
	 */
	public function relations()
	{
		$a = parent::relations();
		$a['subConditions']=array(self::HAS_MANY, 'Condition', 'parentid', "condition"=>"id!=0" );
		$a['parentCondition']=array(self::BELONGS_TO, 'Condition', 'parentid', "condition"=>'id!=0' );
		return($a);
	}
	
	public function getConditionList()
	{
		return($this->getPropertyList());
	}
	
	public function getConditionListForDisplay() {
		return($this->getPropertyListForDisplay());
	}
	
	public function getConditionListForCreate()
	{
		$target = Yii::app()->params['categoryCreate'];
		$a = array();
		
		//get the this for sale: new, old, broken, in the subcategory of #1
		$list = Condition::model()->getAllTreeById($target);
		foreach ($list as $i => $cdt)
		{
			if ($cdt->id != $target)
			{
				$a[$cdt->id] = $cdt->title;
			}
		}
		$a[""] = "";
		return($a);
	}
}