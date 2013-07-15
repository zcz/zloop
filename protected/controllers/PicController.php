<?php

class PicController extends ZLOOPController
{
	
	public function init() {
		//add this controller's title
		parent::init();
		$this->addToTitle("pic");
		header("Content-Type: image");
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
				'actions'=>array('index','view', 'viewSmall', 'viewLarge'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{		
		$pp = $this->loadModel($id);
		echo $pp->data;
	}
	
	public function actionViewLarge($id)
	{
		$pp = $this->loadModel($id);
		echo $pp->data;
	}
	
	public function actionViewSmall($id)
	{
		$pp = $this->loadModel($id);
		echo $pp->icon;
	}
	

	public function actionOne($id)
	{
		$this->render('_view',array('model'=>$this->loadModel($id)));
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
		$dataProvider=new CActiveDataProvider('Pic');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pic('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pic']))
			$model->attributes=$_GET['Pic'];

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
		$model=Pic::model()->findByPk($id);
		if($model===null) {
			$model=Pic__Removed::model()->findByPk($id);
			if ($model === null) {
				$this->redirect(Pic::model()->getSafeDefaultPicUrl());
			} 
		}
		return $model;
	}

/*
	public function loadModelByForeignKey($itemid)
	{
		$model=Pic::model()->findByAttributes("itemid=:itemdid", array(":itemid"=>$itemid) );
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');		
		return $model;
	}
*/

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pic-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
