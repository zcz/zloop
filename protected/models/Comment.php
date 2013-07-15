<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property integer $id
 * @property string $content
 * @property integer $itemid
 * @property integer $userid
 */
class Comment extends SafeActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content', 'required'),
			array('isprivate', 'boolean'),
			array('reply', 'required', 'on'=>'reply'),
			array('content, reply', 'safe', 'on'=>'search')
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'item'=>array(self::BELONGS_TO, 'Item', 'itemid' ),
 			'user'=>array(self::BELONGS_TO, 'User', 'userid' ),	
		);
	}
	
	public function getJSON() {
		return CJSON::encode($this);
	}
	
	public function newCommentNewEmail() {
		$toPerson = $this->item->user->email;
		$title = "ZLOOP -- New Question for [Item: " . $this->item->title . "]";
		$body = Yii::app()->controller->renderPartial("/email/partialNewComment", array('comment'=>$this), true);
		$email = new Email("create");
		$email->toemail = $toPerson;
		$email->title = $title;
		$email->body = $body;
		$email->save();
	}

	public function replyCommentNewEmail() {
		$toPerson = $this->user->email;
		$title = "ZLOOP -- Your Question on [Item: " . $this->item->title . "] got answered";
		$body = Yii::app()->controller->renderPartial("/email/partialReplyComment", array('comment'=>$this), true);
		$email = new Email("create");
		$email->toemail = $toPerson;
		$email->title = $title;
		$email->body = $body;
		$email->save();
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'content' => 'Ask a question',
			'reply' => 'Answer a question',
			'userid' => 'From user',
			'isprivate' => 'Private?',
		);
	}
	
	public function getCriteriaForItemId( $itemId ) {
		$theItem = Item::model()->findByPk($itemId);
		$userid = Yii::app()->user->id * 1;
		
		if ($theItem!=null && $theItem->userid == Yii::app()->user->id) {
			$owner_condition = "'1'='1'";
		} else {
			$owner_condition = "'1'='0'";
		}
		
		//privacy control
		$private_control = " AND (isprivate=FALSE OR ( userid=$userid OR $owner_condition ) ) ";
		return array(
				'condition'=>"itemid=$itemId".$private_control,
				'order'=>'create_time DESC',
		);
	}
	
	public function getDataProviderForItem($item) {
		$dataProvider=new CActiveDataProvider('Comment', array(
				    'criteria'=>$this->getCriteriaForItemId($item->id),
				    'pagination'=>array('pageSize'=>10,),
		));
		return($dataProvider);
	}
	
	public function getCommentByItemid( $itemId ) {
		return $this->findAll($this->getCriteriaForItemId($itemId));
	}

	public function beforeSave()
	{
		if(parent::beforeSave())
    	{
			if (Yii::app()->user->isGuest)
			{
				$this->addError('content', "Please Log In first." );
				return false;
			}		
			if (Yii::app()->user->id === $this->item->userid && $this->scenario=="create")
			{
				$this->addError('content', "You can not comment on yourself.");
				return false;
			}

			if($this->isNewRecord)
        	{
				$this->userid=Yii::app()->user->id;
				$this->create_time=time();
				
				$this->item->status->commented();
			}	
			return true;
    	}
	}

	protected function afterSave()
	{
		if ($this->scenario=="create") {
			//add to db in order to send email
			$this->newCommentNewEmail();
		}
		if ($this->scenario=="reply") {
			$this->scenario="";
			//add to db in order to send email for reply notification
			$this->replyCommentNewEmail();
			$this->replied();
		}
		parent::afterSave();
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchForReply()
	{
		//echo "itemis".$item;
		$criteria=new CDbCriteria;

		$criteria->compare('itemid',$this->itemid);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('reply',$this->reply,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	//called by conmmentcontroller.actionUpdate, to define the item is replied
	public function replied()
	{
		
		$this->reply_time = time();
		$this->save(false, "reply_time");
		$this->item->status->lastreply = time();
		$this->item->status->save(false, "lastreply");
	}
	
	public function replyViewed()
	{
		$this->check_time = time();
		return($this->save(false, "check_time"));
	}
	
	//return the comment that has reply, but not checked by the author
	public function notification($uid)
	{
		$criteria=new CDbCriteria;
		$criteria->condition="userid = :userid AND reply_time > check_time";
		$criteria->params = array(":userid"=>"$uid");

		$comments = $this->findAll($criteria);

		//echo "type is haha".gettype($comments);

		$returnArray = array();
	
		if ($comments != null)
		{
			foreach ($comments as $i => $comment)
			{
				array_push($returnArray, $comment);
			}
		}
		
		return($returnArray);
	}
	
	public function ignoreComment() {
		$this->reply_time = time();
		$this->check_time = time();
		$this->save(false, array('reply_time', 'check_time'));
	}
	
	public function getAnswerLink()
	{
		$linkString = $this->getAnswerUrl();
		$reply_link = CHtml::link('reply', $linkString);
		return($reply_link);
	}
	
	public function getIgnoreLink()
	{
		$linkString = $this->getIgnoreUrl();
		$ignore_link = CHtml::link('ignore', $linkString);
		return($ignore_link);
	}
	
	public function getUri()
	{
		return Yii::app()->createUrl('api/comment/' . $this->id );
	}
	
	public function getAnswerUrl()
	{
		return(Yii::app()->createUrl('comment/update', array("id"=>$this->id)));
	}
	
	public function getIgnoreUrl()
	{
		return(Yii::app()->createUrl('comment/ignore', array("id"=>$this->id)));
	}
	
	public function getViewReplyUrl()
	{
		return(Yii::app()->createUrl('comment/view_reply', array("id"=>$this->id)));
	}
	
	public function searchItemsForUser() {
		$criteria=new CDbCriteria;
		
		$criteria->compare('userid', Yii::app()->user->id);
		$criteria->select='distinct itemid';
		$criteria->order="create_time DESC";
		
		$comments=$this->findAll($criteria);
		$items = array();
		foreach($comments as $i => $comment) {
			array_push($items, $comment->item);
		}
		
		return($items);
	}
	
}
