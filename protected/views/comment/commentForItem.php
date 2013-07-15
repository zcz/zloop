<?php
	$itemid = $item->id;
	$commentForm = new Comment("create");
	$commentForm->itemid=$itemid;
	
	$dataProvider = Comment::model()->getDataProviderForItem($item);

	if (!($item->userid == Yii::app()->user->id)) {
		//a user can not leave question to him/her self
		$this->renderPartial('/comment/_f_comment', array('model'=>$commentForm));
	}
	
	//render the data part, all the comments
	$this->renderPartial('/comment/_i_comment',array('dataProvider'=>$dataProvider));
?>