<?php

/**
 * This is the model class for table "{{message}}".
 *
 * The followings are the available columns in table '{{message}}':
 * @property integer $id
 * @property integer $fromid
 * @property integer $toid
 * @property string $content
 * @property integer $parentid
 * @property integer $create_time
 * @property integer $check_time
 * @property integer $isprivate
 */
class Message extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Message the static model class
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
		return '{{message}}';
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
			array('content', 'safe', 'on'=>'search'),
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
			'fromuser'=>array(self::BELONGS_TO, 'User', 'fromid' ),
		 	'touser'=>array(self::BELONGS_TO, 'User', 'toid' ),	
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'content' => 'Leave a Message',
			'create_time' => 'Create Time',
			'check_time' => 'Check Time',
			'isprivate' => 'Private?',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('fromid',$this->fromid);
		$criteria->compare('toid',$this->toid);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('parentid',$this->parentid);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('check_time',$this->check_time);
		$criteria->compare('isprivate',$this->isprivate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getDataProviderForUser($visiterid, $userid) {
		//privacy control
		$private_control = " AND (isprivate=FALSE OR ( fromid=$visiterid OR toid=$visiterid ) ) ";
		
		$dataProvider = new CActiveDataProvider('Message', array(
						    'criteria'=>array(
						        'condition'=>"(fromid=$userid OR toid=$userid) ".$private_control,
						        'order'=>'create_time DESC',
				),
						    'pagination'=>array(
						        'pageSize'=>10,
				),
		));
			
		return($dataProvider);
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
				
			if($this->isNewRecord)
			{
				$this->create_time=time();
			}				
			return true;
		}
	}
	
	public function newMessageNewEmail() {
		$toPerson = $this->touser->email;
		$title = "ZLOOP -- [User : " . $this->fromuser->username . "] send you a message";
		$body = Yii::app()->controller->renderPartial("/email/partialNewMessage", array('message'=>$this), true);
		$email = new Email("create");
		$email->toemail = $toPerson;
		$email->title = $title;
		$email->body = $body;
		$email->save();
	}
	
	public function messageViewed()
	{
		if (Yii::app()->user->id != $this->toid) return;
		$this->check_time = time(); 
		$this->save();
	} 
	
	//return the new message list that not been viewed
	public function notification($uid)
	{
		$criteria=new CDbCriteria;
		$criteria->condition="toid = $uid AND check_time = 0";
	
		$messages = $this->findAll($criteria);
		
		$returnArray = array();
		
		if ($messages != null)
		{
			foreach ($messages as $i => $message)
			{
				array_push($returnArray, $message);
			}
		}
		
		return($returnArray);
	}
	
	public function getReplyLink( $htmlArray = Array() )
	{
		$replyString = $this->getReplyUrl();
		$reply_link = CHtml::link('reply', $replyString, $htmlArray);
		return($reply_link);
	}
	
	public function getReplyUrl()
	{
		return(Yii::app()->createUrl('message/reply', array('messageid'=>$this->id)));
	}
}