<?php

class CategoryController extends ZLOOPController
{
	
	public function init() {
		//add this controller's title
		parent::init();
		$this->addToTitle("Category");
	}
	
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index', 'view', 'listAllCategories', 'moreView'),
				'users'=>array('*'),
			),
			/*
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			*/
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->addToTitle($this->loadModel($id)->title);
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
		
		Yii::log("view category $id");
	}
	
	
	public function actionMoreView($id = 0)
	{
		$this->addToTitle($this->loadModel($id)->title);
		$keys=new SearchKeysForm;
		$keys->categoryid = $id;
		$keys->conditionid = Yii::app()->params['defaultViewCondition'];
		$dataProvider=Goods::model()->searchItems_DataProvider($keys);
		$this->render('/item/index',array(
					'dataProvider'=>$dataProvider, 
					'model' => $keys
		));
	}
	
	/**
	 * This function is a test for session, a item can have category 
	 * and the setup page is rendered in this function, but the call
	 * back url, variableName and acturalNumber is assigned buy the 
	 * calling function
	 * 
	 * used by item creation and modification, 
	 * first the creation will call this function to get a category
	 */
	public function actionListAllCategories()
	{
		if (isset($_GET['selectedCategory']))
		{
			$callBackUrl = Yii::app()->session['callBackUrl'];
			$callBackVar = Yii::app()->session['callBackVar'];
			$callBackNum = Yii::app()->session['callBackNum'];
			Yii::app()->session['categoryid'] = $_GET['selectedCategory'];
			$this->redirect(array($callBackUrl, $callBackVar=>$callBackNum));
		}
		else
		{
			$this->render("listAllCategories"); 		
		}	
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
