<?php

class ApiController extends ZLOOPController
{
	protected function beforeAction($action)
	{
		//$this->layout=false;
		//header('Content-type: application/json');
		return true;
	}
	
	// Members
	/**
	* Key which has to be in HTTP USERNAME and PASSWORD headers
	*/
	Const APPLICATION_ID = 'ASCCPE';
	
	/**
    * Default response format
	* either 'json' or 'xml'
	*/
	private $format = 'json';
	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	public function accessRules()
	{
		return array(
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions'=>array('login', 'list', 'view', 'create', 'update' ),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('checkSession'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
						//'message'=>'Access Denied.',
						'deniedCallback'=>array($this, 'sessionFailed'),
				),
		);
	}
	
	public function actionCheckSession() {
		$this->sendResponse(200, "good");
	}
	
	public function sessionFailed($rule) 
	{
		$this->sendResponse(401, '{"error":"session failed"}' );
	}
	
	public function actionLogin()
	{
		$data = CJSON::decode(file_get_contents('php://input'));
		$model=new LoginForm;
		$model->attributes=$data;
		// validate user input and redirect to the previous page if valid
		if($model->validate() && $model->login()) {
			// user log in
			Yii::log("api: user log in");
			$user = User::model()->findByEmail($model->username);
			$this->sendResponse(200, CJSON::encode($user));
		} else {
			// log for failed login attempt, without password, for security reason
			Yii::log("login faild: email:$model->username");
			$this->sendResponse(401, '{"error":"para invalid or username & password not match"}' );
		}
	}

	
	// Actions
	public function actionList()
	{
		// Get the respective model instance
		switch($_GET['model'])
		{
			case 'pic':
				$models = Pic::model()->findAll();
				foreach($models as $pic) {$pic->data = "";$pic->icon = "";}
				break;
			case 'item':
				//defind the search criteria
				$keyWord = new SearchKeysForm;
				if (isset($_GET['categoryId'])) $keyWord->categoryid = $_GET['categoryId'];
				if (isset($_GET['conditionId'])) $keyWord->conditionid = $_GET['conditionId'];
				if (isset($_GET['keyString'])) $keyWord->keyString = $_GET['keyString'];

				$models = Goods::model()->searchItems($keyWord);
				break;
			case 'user' :
				$models = User::model()->findAll();
				break;
			case 'comment' :
				if(!isset($_GET['itemId'])) $this->sendResponse(500, 'Error: Parameter <b>itemId</b> is missing' );
				$models = Comment::model()->getCommentByItemid($_GET['itemId']);
				break;
			default:
				// Model not implemented error
				$this->sendResponse(501, sprintf( 'Error: Mode <b>list</b> is not implemented for model <b>%s</b>', $_GET['model']) );
				Yii::app()->end();
		}
		
		// Did we get some results?
		if(empty($models)) {
			// No
			$this->sendResponse(200, sprintf('No items where found for model <b>%s</b>', $_GET['model']) );
		} else {
			// Prepare response
			$rows = array();
			foreach($models as $model)
				$rows[] = CJSON::decode($model->getJSON());
			// Send the response
			$this->sendResponse(200, CJSON::encode($rows));
		}
		
	}
	
	public function actionView()
	{
		// Check if id was submitted via GET
		if(!isset($_GET['id'])) 
			$this->sendResponse(500, 'Error: Parameter <b>id</b> is missing' );
		
		switch($_GET['model'])
		{
			case 'pic':
				$model = Pic::model()->findByPk($_GET['id']);
				$this->redirect($model->getUrl());
				break;
			case 'item':				
				$model = Item::model()->findByPk($_GET['id']);
				break;
			case 'user':
				$model = User::model()->findByPk($_GET['id']);
				break;
			case 'comment' :
				$model = Comment::model()->findByPk($_GET['id']);
				break;
			default:
				$this->sendResponse(501, sprintf(
				'Mode <b>view</b> is not implemented for model <b>%s</b>',
				$_GET['model']) );
				Yii::app()->end();
		}
		// Did we find the requested model? If not, raise an error
		if(is_null($model))
			$this->sendResponse(404, 'No Item found with id '.$_GET['id']);
		else
			$this->sendResponse(200, $model->getJSON());
	}
	
	public function actionCreate()
	{
		switch($_GET['model'])
		{
			
			case 'pic':
				$pic = new Pic;
				if ($_FILES["pic"] != null)
				{
					Yii::log("api: pic upload called");
					$pic->data = file_get_contents($_FILES["pic"]["tmp_name"]);
					$pic->save();
					Yii::log("api: pic [id:".$pic->getPrimaryKey()."] added from user computer");
					$pic->data = "";
					$pic->icon = "";
					header('Location: '.$pic->getUri());
					$this->sendResponse(200);
				}
				break;
			case 'item':
				if (Yii::app()->user->id == 0) {
					$this->sendResponse(401, '{"error":"session failed"}' );
				}
				
				$data = CJSON::decode(file_get_contents('php://input'));
				$model= new Item;
				$model->attributes=$data;
				// user id, auto added by system
				// tags $tags=new Tag;
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->save()) {
					//add pics
					if (isset($data['pics'])){
						foreach ($data['pics'] as $s) {
							$s = $s['uri'];
							$id = (int)preg_replace('/\D/', '', $s);
							$pic = Pic::model()->findByPk($id);
							if ($pic != null && $pic->itemid == 0) {
								$pic->itemid = $model->id;
								$pic->save();
							}
						}
					}
					Yii::log("api: add item " . $model->id);
					header('Location: '.$model->getUri());
					$this->sendResponse(200);
				}
				break;	
			case 'comment' :
				if (Yii::app()->user->id == 0) {
					$this->sendResponse(401, '{"error":"session failed"}' );
				}
				$data = CJSON::decode(file_get_contents('php://input'));
				$model = new Comment("create");
				$model->itemid=$data['itemid'];
				$model->attributes=$data;
				if($model->validate() && $model->save()) {
					//for comment create log
					Yii::log("api: new comment [ID:$model->id], [item:$model->itemid]");
					header('Location: '.$model->getUri());
					$this->sendResponse(200);
				}
				break;
			default:
				$this->sendResponse(501,
				sprintf('Mode <b>create</b> is not implemented for model <b>%s</b>',
				$_GET['model']) );
				Yii::app()->end();
		}

		// Errors occurred
		$msg = "<h1>Error</h1>";
		$msg .= sprintf("Couldn't create model <b>%s</b>", $_GET['model']);
		$msg .= "<ul>";
		foreach($model->errors as $attribute=>$attr_errors) {
			$msg .= "<li>Attribute: $attribute</li>";
			$msg .= "<ul>";
			foreach($attr_errors as $attr_error)
				$msg .= "<li>$attr_error</li>";
			$msg .= "</ul>";
		}
		$msg .= "</ul>";
		$this->sendResponse(500, $msg );
	}

	public function actionUpdate()
	{		
		switch($_GET['model'])
		{
			case 'comment':
				if (Yii::app()->user->id == 0) {
					$this->sendResponse(401, '{"error":"session failed"}' );
				}
				$data = CJSON::decode(file_get_contents('php://input'));
				$model = Comment::model()->findByPk($_GET['id']);
				// Did we find the requested model? If not, raise an error
				if($model === null)	$this->sendResponse(400, sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.", $_GET['model'], $_GET['id']) );
				if ($model->item->userid != Yii::app()->user->id) $this->sendResponse(400, '{"error":"you are not the owner"}' );
				$model->setScenario('reply');
				$model->reply=$data['reply'];
				break;
			default:
				$this->sendResponse(501,
				sprintf( 'Error: Mode <b>update</b> is not implemented for model <b>%s</b>',
				$_GET['model']) );
				Yii::app()->end();
		}

		// Try to save the model
		if($model->validate() && $model->save()){
			Yii::log("api: update " .$_GET['model']. "[ID:$model->id]");
			$this->sendResponse(200, CJSON::encode($model));
		}
		else
			// prepare the error $msg
			// see actionCreate
			// ...
		$this->sendResponse(500, $msg );
	}
	
/*
	public function actionDelete()
	{
		switch($_GET['model'])
		{
			// Load the respective model
			case 'posts':
				$model = Post::model()->findByPk($_GET['id']);
				break;
			default:
				$this->sendResponse(501,
				sprintf('Error: Mode <b>delete</b> is not implemented for model <b>%s</b>',
				$_GET['model']) );
				Yii::app()->end();
		}
		// Was a model found? If not, raise an error
		if($model === null)
			$this->sendResponse(400,
					sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",
							$_GET['model'], $_GET['id']) );
		
		// Delete the model
		$num = $model->delete();
		if($num>0)
			$this->sendResponse(200, $num);    //this is the only way to work with backbone
		else
			$this->sendResponse(500,
					sprintf("Error: Couldn't delete model <b>%s</b> with ID <b>%s</b>.",
							$_GET['model'], $_GET['id']) );
	}
*/
	
}