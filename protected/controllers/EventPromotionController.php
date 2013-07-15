<?php

class EventPromotionController extends ZLOOPController
{	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/*
	 * just for test
	 */
	public function actionTest()
	{
		$this->redirect(array("/site/index"));
		//Yii::log("testing... ");
		//$i = 1 + 2;
		//$this->render("test", array('value'=>$i, "value2"=>$i+$i));
	}
	
	public function actionIndex()
	{
		//redirect to front page, the event is gone
		$this->redirect(array("/site/index"));
		
		//$this->render('index');
		//Yii::log("Event promotion viewed.");
	}
}