<?php

class UserController extends ZLOOPController
{
	//in order to calculate a single login
	//define two action time should not be longer
	//than 60 seconds
	private $oneLoginTime = 60;

	public function init() {
		//add this controller's title
		parent::init();
		$this->addToTitle("User");
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
				'actions'=>array('create'),
				'users'=>array('*'),
			),
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view', 'viewMe', 'update', 'editPic', 'changePassword', 'moreItems', 'moreViewedItems', 'moreCommentedItems'),    //need to be added after finished
				'users'=>array('@'),
			),
			
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('admin', 'delete'),
				'users'=>array('admin'),
			),
			
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
		$viewUser = $this->loadModel($id);
		$this->addToTitle($viewUser->username);
		$userid = $id;
		$visiterid = Yii::app()->user->id;
		if (!isset($visiterid) || $visiterid ==0) $visiterid = '0';
		
		$dataProvider = Message::model()->getDataProviderForUser($visiterid, $userid);
			
		$this->render('view', array(
			'model'=>$viewUser,
			'dataProvider'=>$dataProvider
		));
		
		Yii::log("view user, [id=$id]");
	}
	
	public function actionViewMe()
	{
		//$this->addToTitle("My Zloop");
		$this->actionView(Yii::app()->user->id);
		Yii::log("user view self profile");
	}

	public function actionMoreItems( $id ) {
		$this->addToTitle($this->loadModel($id)->username);
		$this->redirect(array(
			'/item/index',
			'userId'=>$id
		));
	}
	
	public function actionMoreViewedItems() {
		$this->addToTitle(Yii::app()->user->name);
		$this->addToTitle("Viewed Items");
		$keys=new SearchKeysForm;
		$keys->specialAction = Yii::app()->params['specialAction_view'];
		$dataProvider=Goods::model()->searchItems_DataProvider($keys);
		$this->render('/item/index',array(
			'dataProvider'=>$dataProvider, 
			'model' => $keys
		));
	}
	
	public function actionMoreCommentedItems() {
		$this->addToTitle(Yii::app()->user->name);
		$this->addToTitle("Commented Items");
		$keys=new SearchKeysForm;
		$keys->specialAction = Yii::app()->params['specialAction_commented'];
		$dataProvider=Goods::model()->searchItems_DataProvider($keys);
		$this->render('/item/index',array(
			'dataProvider'=>$dataProvider, 
			'model' => $keys
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->addToTitle("Create Account");
		$model=new User('create');

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$temp_passwd = $_POST['User']['password'];
			$temp_usernm = $_POST['User']['email'];
			if($model->validate()&&$model->save())
			{
				//log create new uesr
				Yii::log("new user sign up, email:$model->email");
				
				$emailServe = new EmailSending();
				$emailServe->sendEmailConfirm($model);
				
				$model->moveToWaitConfirm();
				$this->redirect(array('email/waitConfirm'));
			}
		}

		$this->render('create',array('model'=>$model));
	}

	public function actionEditPic($id)
	{
		$this->addToTitle("Edit Profile Picture");
		//one user can only update him/her self's portfolio
		if (Yii::app()->user->id != $id)
			$this->redirect(array("site/index"));
		
		$user = $this->loadModel($id);
		$pic = new Pic('create');
		
		if (isset($_GET['deleteId']) && $_GET['deleteId']>0)
		{
			$pic = Pic::model()->findByPk($_GET['deleteId']);
			$picId = $pic->id;
			Yii::log("user profile picture deleted, picId=$picId");
			$pic->delete();
			$this->redirect(array("update","id"=>$id));
		}
		
		if (isset($_POST['addOnePic']))
		{
			$pic->attributes=$_POST['Pic'];
			$pic->data = CUploadedFile::getInstance( $pic, "data" );
			if ($pic->validate() && ($pic->data != null))
			{		
				if ($user->profilePic != null)
				{
					$user->profilePic->delete();
				}			
				$pic->itemid = 0;
				$pic->data = file_get_contents($pic->data->tempName);
				$pic->save();
				$user->profilepicid = $pic->getPrimaryKey();
				$user->save(false, array('profilepicid'));
				$picId = $pic->id;
				Yii::log("user profile picture added, picId=$picId");
				$this->redirect(array("update","id"=>$id));
			}
		}
		
		$this->redirect(array('update','id'=>$user->id));
	}
	
	public function actionChangePassword($id)
	{
		$this->addToTitle("Change Password");
		//one user can only update him/her self's portfolio
		if (Yii::app()->user->id != $id)
			$this->redirect(array("site/index"));
		
		$user=$this->loadModel($id);
		$model = new ChangePasswordForm();
		$model->user = $user;
		
		if(isset($_POST['ChangePasswordForm']))
		{
			$model->attributes=$_POST['ChangePasswordForm'];
			$model->passwordChanged = false;
			if ($model->validate())
			{
				Yii::log("user change password");
				$user->password = $model->passwordHash;
				$user->save(false, "password");
				$model->passwordChanged = true;
			}
		}
		$this->render("changePassword", array('model'=>$model));
	}
	
	public function actionUpdate($id)
	{
		$this->addToTitle("Profile");
		//one user can only update him/her self's portfolio
		if (Yii::app()->user->id != $id)
			$this->redirect(array("site/index"));
		
		$model=$this->loadModel($id);
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->validate()&&$model->save())
			{				
				Yii::log("user update info");
				Yii::app()->user->setFlash('actionDone','User information updated.');
				$this->refresh();
			}
		}
		
		$this->render('update',array('model'=>$model));

	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();
	
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
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null) {
			//throw new CHttpException(404,'The requested page does not exist.');
			$this->redirect(array("/site/pageMissing"));
		}			
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
