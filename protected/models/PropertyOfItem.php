<?php
class PropertyOfItem extends SafeActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getAllTreeById($id)
	{
		$root = $this->findByPk($id);
		if ($root===null)
			return null;
		else
			return($root->getTreeRecursive());
	}
	
	public function getTreeRecursive()
	{
		$tree = array();
		array_push($tree, $this);
		foreach($this->children as $i=>$child)
		{
			$tree = array_merge($tree, $child->getTreeRecursive());
		}
		return($tree);
	}

	//return the name(title) list of that property
	public function getPropertyList($id=0)
	{
		$list = array();
		$tree = $this->getAllTreeById($id);
		foreach($tree as $i => $property)
		{
			$list[$property->id] = $property->title;
		}
		return($list);
	}
	
	public function getPropertyListForDisplay($id=0)
	{
		$list = array();
		$tree = $this->getAllTreeById($id);
		foreach($tree as $i => $property) {
			if ($property->id >= 100) {
				$list[$property->id] = "++" . $property->title;
			} else {
				$list[$property->id] = $property->title;
			}
		}
		return($list);
	}
	
	/**
	* @return array relational rules.
	*/
	public function relations()
	{
		return array(
			'children'=>array(self::HAS_MANY, get_class($this), 'parentid', "condition"=>"id!=0" ),
			'parent'=>array(self::BELONGS_TO, get_class($this), 'parentid', "condition"=>'id!=0' ),
		);
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
		array('title, detail', 'required'),
		array('title', 'length', 'max'=>255),
		array('id, title, detail', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'detail' => 'Detail',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('detail',$this->detail,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	//returns the search criteria like : conditionid = 2 OR conditionid = 3
	//it will be shared with condition and category class
	public function getSearchCriteriaById($id = 0)
	{
		$list = $this->getAllTreeById($id);
		$s = "";
		foreach ($list as $i=>$one)
		{
			if (!isset($logicConnecter)) $logicConnecter = "";
			else $logicConnecter = " OR ";
			$s .= $logicConnecter.$this->foreignKey().'='.$one->id;
		}
		$s = '('.$s.')';
		return($s);
	}
	
}