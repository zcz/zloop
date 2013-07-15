<?php

class JSONController extends ZLOOPController
{

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('itemById', 'itemsByUserId', 'simple', 'picsByItemid'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('userByEmail','userById'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	protected function beforeAction($action)
	{
		$this->layout=false;
		header('Content-type: application/json');
		return true;
	}

	public function actionUserByEmail($email)
	{
		$user = User::model()->findByEmail($email);
		//echo $user->toJSON();
		echo CJSON::encode($user);
	}
	

	public function actionUserById($id)
	{
		$user = User::model()->findByPk($id);
		//echo $user->toJSON();
		echo CJSON::encode($user);
	}
	
	public function actionItemById($id)
	{
		$item = Item::model()->findByPk($id);
		$s = CJSON::decode(CJSON::encode($item));
		$pics = array();
		foreach($item->pictures as $i => $attach)
		{
			$pics[] = $attach->getUrl();
		}
		$s['pics'] = $pics;
		echo CJSON::encode($s);
		//print_r( $item );
	}
	
	public function actionItemsByUserId($userid)
	{
		$user = User::model()->findByPk($userid);
		//echo $user->toJSON();
		echo CJSON::encode($user->items);
	}
	
	public function actionSimple()
	{
		echo '{"name": "TEXAS","abbreviation":"TX"}';
	}
}
