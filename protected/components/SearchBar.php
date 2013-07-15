<?php

/**
 * for the search bar component, get the search 
 * @author zcz
 *
**/

class SearchBar extends CWidget
{	
	public function run()
	{
		$keys=new SearchKeysForm;
		
		if(isset($_POST['SearchKeysForm']))
		{
			$keys->attributes = $_POST['SearchKeysForm'];
	
			Yii::app()->controller->redirect(array(
						'/item/index',
						"keywords"=>$keys->keyString,
						'categoryId'=>$keys->categoryid,
						'conditionId'=>$keys->conditionid
			));
		} else
		{
			$this->render('_f_searchkeys', array('model'=>$keys, 'hide_category'=>true));
		}
	}
}