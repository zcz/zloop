<?php

class CommentController extends ZLOOPController
{
	
	public function init() {
		//add this controller's title
		parent::init();
		$this->addToTitle("Question And Answer");
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//role control
			'update_ignore + update, ignore',
		);
	}
	
	public function filterUpdate_ignore($filterChain) {
		if (!Yii::app()->user->isGuest && Yii::app()->user->id != Yii::app()->params['adminAccountNumber']) {
			if (isset($_GET['id'])) {
				$id = $_GET['id'];
				$model = $this->loadModel($id);
				if ($model == null || $model->item->userid != Yii::app()->user->id) {
					$this->redirect(array("site/pageMissing"));
				}
			} else {
				$this->redirect(array("site/pageMissing"));
			}
		}
		$filterChain->run();
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
				'actions'=>array('index','view', 'view_reply', 'showItemComments'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'update', 'ignore'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'users'=>array('admin'),
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionCreate($id) {
		if(isset($_POST['Comment'])) {
			$commentForm = new Comment("create");
			$commentForm->itemid=$id;
			$commentForm->attributes=$_POST['Comment'];
			if($commentForm->validate() && $commentForm->save()) {
				//for comment create log
				Yii::log("new comment[ID:$commentForm->id], [item:$commentForm->itemid]");
			}
		}
		$this->redirect(array("item/view", "id"=>$id));
	}
	
	/**
	 * only used for redirect to view_reply, if there is any reply
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render('view_reply',array('model'=>$model));
	}

	public function actionView_reply($id)
	{
		$model = $this->loadModel($id);
		$model->replyViewed();
		$this->render('view_reply',array('model'=>$model));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->setScenario('reply');
		if(isset($_POST['Comment']['reply']))
		{
			$model->reply=$_POST['Comment']['reply'];
			if ($model->validate() && $model->save())
			{
				Yii::log("reply commnet[ID:$model->id], [item:$model->itemid]");	
				$this->redirect(array('item/view','id'=>$model->itemid));
			}
		} else {
			$this->render('update',array('model'=>$model));
		}
	}
	
	public function actionIgnore($id)
	{
		$model=$this->loadModel($id);
		$model->ignoreComment();
		Yii::log("ignore commnet[ID:$model->id], [item:$model->itemid]");					
		$this->redirect(array('item/view','id'=>$model->itemid));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id, $scenario = "")
	{
		$model=Comment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
