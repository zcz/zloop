<?php
/**
 * This is the category notification bar, will list all the category's belong's to the 
 * parent category. 
 * Usage: call this widget with a category id inside.
 * 
 * @author zcz
 */

class CategoryNavigation extends CWidget
{
	public $categoryId = 0;
	private $category = null;
	
	public function init() 
	{
		$this->category = Category::model()->findByPk($this->categoryId);
	}
	
	public function run() 
	{
		$s = "";
		if ($this->category != null)
		{
			$s .= '<div valign="top" style="margin-top: 4px; width=194px; float:left">';
			$s .= $this->renderMenu();
			$s .= '</div>';
		}	
		echo $s;
	}
	
	public function renderMenu()
	{
		$s = "";
				
		if ($this->category != null)
		{
			$s .= '<link rel="stylesheet" href="';
			$s .= Yii::app()->request->baseUrl;
			$s .= '/css/categoryNav.css" type="text/css"/ media="screen">';
			$s .= '<div id="menu">';
			
			foreach ($this->category->subCategories as $i => $subCategory)
			{
				$s .= $this->renderOneRow($subCategory);
			}
		
			$s .= '</div>';		
		}

		return($s);
	}
	
	public function renderOneRow($category)
	{
		$s = "";
		$s .= '<ul>';
		$s .=  '<li>';
		$s .=   '<ul>';
		$s .=    '<li><a href='.$category->getUrl().' title="More">'.$category->title.'<p style="position:absolute;right:5px;display:inline">&gt;</p></a>';
		if ($category->subCategories != null)
		{
			$s .=     '<ul>';
			foreach ($category->subCategories as $i => $subCategory)
			{
				$s .= $this->renderSubCategory($subCategory);
			}
			$s .=     '</ul>';	
		}
		$s .=    '</li>';
		$s .=   '</ul>';
		$s .=  '</li>';
		$s .= '</ul>';
		return($s);
	}
	
	public function renderSubCategory($category)
	{
		$s = '<li><a href='.$category->getUrl().' title="More">'.$category->title.'</a></li>';
		return($s);
	}
}