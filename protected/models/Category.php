<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $id
 * @property string $title
 * @property string $detail
 */
class Category extends PropertyOfItem
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getCategoryList() {
		return($this->getPropertyList());
	}
	
	public function getCategoryListForDisplay() {
		return($this->getPropertyListForDisplay());
	}
	
	
	public function getFullName()
	{
		$s = $this->title;
		if ($this->parentCategory !== null)
		{
			$s .= ", ".$this->parentCategory->getFullName();
		}
		return($s);
	}
	
	public function getPathBreadCrumbs()
	{
		$a = array();
		
		if ($this->parentid != 0)
		{
			$a = $this->parentCategory->getPathBreadCrumbs();
		}
		//$a[$this->title] = array('category/view', 'id'=>$this->id);
		$a[$this->title] = $this->getUrl();
		return($a);
	}
	
	public function tableName()
	{
		return '{{category}}';
	}
	
	public function foreignKey()
	{
		return 'categoryid';
	}

	/**
	 * this version is different from properties, 
	 * because it is easier to use this version.
	 * @return array relational rules.
	 */
	public function relations()
	{
		$a = parent::relations();
		$a['subCategories']=array(self::HAS_MANY, 'Category', 'parentid', "condition"=>"id!=0" );
		$a['parentCategory']=array(self::BELONGS_TO, 'Category', 'parentid', "condition"=>'id!=0' );
		return($a);
	}
	
	public function getUrl() {
		//return Yii::app()->createUrl('category/view', array('id'=>$this->id));
		return(parent::getFullAndSafeUrl("category/view", array("id"=>$this->id)));
	}
	
	public function gerMoreViewUrl() {
		//array("/category/moreView", 'id'=>$model->id);
		return(parent::getFullAndSafeUrl("category/moreView", array("id"=>$this->id)));
	}
	
}