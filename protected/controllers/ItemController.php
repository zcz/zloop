<?php

class ItemController extends ZLOOPController
{	
	
	public function init() {
		//add this controller's title
		parent::init();
		$this->addToTitle("Item");
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//role control
			'modify_delete_control + delete, update, addPic, updateCategory, markAsSold, renewItem',
		);
	}
	
	public function filterModify_delete_control($filterChain) {
		if (!Yii::app()->user->isGuest && Yii::app()->user->id != Yii::app()->params['adminAccountNumber']) {
			if (isset($_GET['id'])) {
				$id = $_GET['id'];
				$item = $this->loadModel($id);
				if ($item == null) {
					$this->redirect(array("itemMissing"));
				}
				if ($item->userid != Yii::app()->user->id) {
					Yii::app()->user->setFlash('actionError','Sorry, action denied, you are not the owner of this item.');
					$this->redirect(array('view','id'=>$id));
				}
			} else {
				$this->redirect(array("itemMissing"));
			}
		}
		$filterChain->run();
	} 

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'showUserItems'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(
						'create', 'createReal', 'admin', 'delete', 
						'updateCategory', 'update', 'addPic', 'markAsSold', 'renewItem'
						),
			  	'users'=>array('@'),
			),
			/*
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'users'=>array('admin'),
			),
			*/
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionMarkAsSold($id) {
		$item = $this->loadModel($id);
		$s = $item->markAsSoldThisItem();
		if (isset($s)) 
			Yii::app()->user->setFlash('actionDone',$s);
		else 
			Yii::app()->user->setFlash('actionError','Sorry, error happened.');
		$this->redirect(array('view','id'=>$id));
	}
	
	public function actionRenewItem($id) {
		$item = $this->loadModel($id);
		$s = $item->renewThisItem();
		if (isset($s))
			Yii::app()->user->setFlash('actionDone',$s);
		else
			Yii::app()->user->setFlash('actionError','Sorry, error happened.');
		$this->redirect(array('view','id'=>$id));
	}

	public function actionView($id)
	{			
		$item = $this->loadModel($id); 	
		$this->addToTitle($item->title);
				
		$this->render('view',array('model'=>$item));

		//log for statistics
		$item->status->viewed();
		Tag::model()->viewItem($item);
		Userviewitem::model()->viewItem($item);
		Yii::log("view itemid: $id");
	}
	
	private function getSessionCategory()
	{
		if (isset(Yii::app()->session['categoryid']))
		{
			$temp = Yii::app()->session['categoryid'];
			unset(Yii::app()->session['categoryid']);
		} else
		{
			$temp = null;
		}
		return($temp);
	}
	
	public function actionCreate()
	{
		Yii::app()->session['callBackUrl'] = "item/create";
		Yii::app()->session['callBackVar'] = "null";
		Yii::app()->session['callBackNum'] = "null";
		$categoryId = $this->getSessionCategory();
		if ($categoryId === null)
		{
			$this->redirect(array("category/listAllCategories"));
		}
		$this->redirect(array("item/createReal", 'categoryId'=>$categoryId));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreateReal($categoryId)
	{
		$this->addToTitle("Post");
		$model=new Item;
		$tags=new Tag;
		$model->categoryid = $categoryId;
		$tagSelected = array();

		$this->processContent($tags, $tagSelected, $model);
				
		if(isset($_POST['submitForm']))
		{
			if ($this->retrieveItemData($model, $tagSelected))
			{
				unset(Yii::app()->session['callBackUrl']);
				unset(Yii::app()->session['callBackVar']);
				unset(Yii::app()->session['callBackNum']);
				//for log
				Yii::log("item [id:".$model->getPrimaryKey()."] created");
				$this->redirect(array('addPic','id'=>$model->id));
			}
		}
		
		$this->render('create',
		array(
		  'model'=>$model, 
		  'tags'=>$tags,
		  'tagSelected'=>$tagSelected,
		));
	}
	
	public function actionUpdateCategory($id)
	{
		$this->addToTitle("Category");
		$categoryId = $this->getSessionCategory();
		if ($categoryId === null)
		{
			$this->redirect(array("category/listAllCategories"));
		}
		$this->redirect(array("item/Update", 'categoryId'=>$categoryId, 'id'=>$id));
	}
	
	public function actionUpdate($id)
	{
		
		$this->addToTitle("Revise");
		Yii::app()->session['callBackUrl'] = "item/updateCategory";
		Yii::app()->session['callBackVar'] = "id";
		Yii::app()->session['callBackNum'] = "$id";
		
		$model=$this->loadModel($id);

        $tags=new Tag;
        if (isset($_GET['categoryId'])) $model->categoryid = $_GET['categoryId'];
		
		if (isset($tagSelected))
		{
			$tagSelected = array();
		} else
		{
			$tagSelected = TagItem::model()->loadTags($model);
		}
		
		$this->processContent($tags, $tagSelected, $model);
						
		if(isset($_POST['submitForm']))
		{
			if ($this->retrieveItemData($model, $tagSelected))
			{
				unset(Yii::app()->session['callBackUrl']);
				unset(Yii::app()->session['callBackVar']);
				unset(Yii::app()->session['callBackNum']);
				//for log
				Yii::log("item [id:".$model->getPrimaryKey()."] updated");
				$this->redirect(array('addPic','id'=>$model->id));
			}
		}
		
		$this->render('update',
			array(
			  'model'=>$model, 
			  'tags'=>$tags,
			  'tagSelected'=>$tagSelected,
			));
	}
	
	public function processContent(&$tags, &$tagSelected, &$model)
	{
		if (isset($_POST["Tag"]['id']))
		{
			$tagSelected = array();
			foreach ($_POST["Tag"]['id'] as $i=>$t)
			{
				if ($t != null && $t != 0)
				{
					$tagSelected[$t] = 0;
				}
			}
		}
		
		if (isset($_POST['addTag']))
		{
			$tagString = $_POST["Tag"]['tagName'];
			Tag::model()->processNewTag($tagString, $tagSelected);
		}
		
		if (isset($_POST['Item']))
		{
			$model->attributes=$_POST['Item'];
		}
	}
	
	public function retrieveItemData(&$model, $tagSelected)
	{
		$model->attributes=$_POST['Item'];
		
		if($model->validate() && $model->save())
		{
			if (Tag::model()->newItemTags($model, $tagSelected))
			{
				return true;
			} else 
			{
				return false;
			}
			
		} else
		{
			return false;
		}
	}

	public function actionAddPic($id)
	{
		
		$this->addToTitle("Add Picture");
		$item = $this->loadModel($id);
		$pic = new Pic;
		$picFull = false;
		$Google_pic_failed = false;
		
		if (isset($_GET['deleteId']))
		{
			Yii::log("pic [id:".$pic->getPrimaryKey()."] deleted from item view");
			$pic = Pic::model()->findByPk($_GET['deleteId']);
			$pic->delete();
			$this->redirect(array("addpic","id"=>$id));
		}
	
		if ($item->ifPicFull() == false) {			
			if (isset($_POST['addOnePic']))
			{
				$pic->attributes=$_POST['Pic'];
				$pic->data = CUploadedFile::getInstance( $pic, "data" );
				if ($pic->validate() && ($pic->data != null))
				{
					$pic->itemid = $item->getPrimaryKey();
					$pic->data = file_get_contents($pic->data->tempName);
					$pic->save();
					Yii::log("pic [id:".$pic->getPrimaryKey()."] added from user computer");
					$this->redirect(array("addpic","id"=>$id));
				}
			}
		
			if (isset($_GET['imgUrl']))
			{
				$url = urldecode($_GET['imgUrl']);
				unset($_GET['imgUrl']);
				$pic->data = @file_get_contents($url);
				if (strpos($http_response_header[0], "200")) {
					$pic->itemid = $item->getPrimaryKey();
					$pic->story = "Image comes from Google Search";
					$pic->save();
					Yii::log("pic [id:".$pic->getPrimaryKey()."] added from google, url = $url");
					$this->redirect(array("addpic","id"=>$id));
					echo "SUCCESS";
				} else {
					Yii::log("pic add from google failed, url = $url");
					//echo "FAILED";
					$Google_pic_failed = true;
				}
			}
		}	
	
		$this->render('addPics',array(
				'item'=>$item, 
				'pic'=>$pic,
				'pic_upload_failed'=>$Google_pic_failed
		));
	}
	
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::log("item [id:".$id."] start deleting");
			$item = $this->loadModel($id);
			// we only allow deletion via POST request
			$item->delete();
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{		
		$this->addToTitle("List Items");
		$keys=new SearchKeysForm;
		
		if(isset($_POST['SearchKeysForm']))
		{
			$keys->attributes = $_POST['SearchKeysForm'];
		} else
		{
			if (isset($_GET['keywords'])) {
				$keys->keyString = urldecode($_GET['keywords']);
			}
			if (isset($_GET['categoryId'])) {
				$keys->categoryid = urldecode($_GET['categoryId']);
			}
			if (isset($_GET['conditionId'])) {
				$keys->conditionid = urldecode($_GET['conditionId']);
			}
			if (isset($_GET['userId'])) {
				$keys->userid = urldecode($_GET['userId']);
			}
		}

		//log the search action
		Yii::log( "search item: $keys->keyString; category=$keys->categoryid; condition=$keys->conditionid; userid=$keys->userid");
		
		$dataProvider=Goods::model()->searchItems_DataProvider($keys);
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 
			'model' => $keys
		));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{		
		$this->addToTitle("Manage");
		$model=new Item('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Item'])) $model->attributes=$_GET['Item'];
		
		if (Yii::app()->user->id != Yii::app()->params['adminAccountNumber']) {
			$model->userid=Yii::app()->user->id;
		}
		
		$this->render('admin',array('model'=>$model,));		
		
		//log for admin items
		Yii::log("manage items");
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Item::model()->findByPk($id);
		if($model===null) {
			//throw new CHttpException(404,'The requested page does not exist.');
			$this->redirect(array("/site/pageMissing"));
		}
		else
 			return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionShowUserItems($userid)
	{
		if ($userid==0 || !isset($userid)) return;
		$thisUser = User::model()->findByPk($userid);
		
		$dataProvider = new CArrayDataProvider( $thisUser->items,
			array('pagination'=>array('pageSize'=>10)) );

		$this->renderPartial("_searchResult", 
			array("dataProvider"=>$dataProvider));
	}
}
