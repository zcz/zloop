<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $address
 * @property string $phone
 */
class User extends UserBase
{
	public $password_repeat;
	public $iagree;
	public $encode_password = false;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username', 'required'),
			array('password', 'compare', 'strict'=>true, 'on'=>'create'),
			array('email, username, password, phone, password_repeat, address', 'length', 'max'=>255),
			array('email', 'email', 'on'=>'create'),
			array('iagree', 'compare', 'compareValue' => true,
					'message' => 'You must agree to the terms and conditions', 'on'=>'create'),
			array('email, password, password_repeat', 'required', 'on'=>'create'),			
			array('sendWeeklyEmail, ifNotify, username, phone, address', 'safe', 'on'=>'update'),
			array('address, password_repeat', 'safe', 'on'=>'create'),
			array('id, email, username, address, phone', 'safe', 'on'=>'search'),
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
			'items'=>array(self::HAS_MANY, 'Item', 'userid' ),
			'frends'=>array(self::HAS_MANY, 'Friend', 'fromid' ),
			'comments'=>array(self::HAS_MANY, 'Comment', 'userid' ),
			'tomessages'=>array(self::HAS_MANY, 'Message', 'toid' ),
			'frommessages'=>array(self::HAS_MANY, 'Message', 'fromid' ),
			'tags'=>array(self::HAS_MANY, 'TagUser', 'userid'),
			'profilePic'=>array(self::BELONGS_TO, 'Pic', 'profilepicid'),
			'extlogins'=>array(self::HAS_MANY, 'Extlogin', 'userid' ),	
			'userviews'=>array(self::HAS_MANY, 'Userviewitem', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'error ID',
			'email' => 'Email',
			'username' => 'Username',
			'password' => 'Password',
			'address' => 'Address',
			'phone' => 'Phone',
			"password_repeat"=>"Password again",		
		);
	}
	
	public function getJSON() {
		return CJSON::encode($this);
	}

	public function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord)
			{
				$find = $this->find('email=:email',array(':email'=>($this->email)));
				if ($find!=null)
				{
					$this->addError( "email", "email used by other account" );
					return false;
				}
				$this->salt = "".uniqid()."".uniqid()."";
				$this->create_time=time();
			}
			// encode the password, and send the user account info email
			if ($this->encode_password == true) {
				$this->encode_password = false;
				$emailServe = new EmailSending();
				$emailServe->sendAccountInfoEmail($this, $this->password);
				$this->password = $this->hashPassword($this->password, $this->salt);
			}
			$this->last_modified=time();
			return true;
		}
		else
		return false;
	}
	
	/**
	* over write beforedelete, to delete the relevent things:
	* items, profiles, profilepicture, externallogins
	*/
	protected function beforeDelete()
	{
		if (parent::beforeDelete())
		{
			// just delete that accout for registration
			if ($this->deleteForRegistration == true) {
				return true;
			}

			if ($this->userviews!=null){
				foreach($this->userviews as $i => $views) {
					if (!$views->delete()) {
						return false;
					}
				}
			}
			
			if ($this->comments!=null){
				foreach($this->comments as $i => $comment) {
					if (!$comment->delete()) {
						return false;
					}
				}
			}

			
			if ($this->items!=null){
				foreach($this->items as $i => $item) {
					if (!$item->delete()) {
						return false;
					}
				}
			}
			
			if ($this->tomessages !=null){
				foreach($this->tomessages as $m => $message) {
					if (!$message->delete()) {
						return false;
					}
				}
			}
			
			if ($this->frommessages !=null){
				foreach($this->frommessages as $m => $message) {
					if (!$message->delete()) {
						return false;
					}
				}
			}
			
			if ($this->tags!=null) {
				foreach($this->tags as $i => $tag) {
					if (!$tag->delete()) {
						return false;
					}
				}
			}

			if ($this->extlogins != null) {
				foreach($this->extlogins as $i => $logins) {
					if (!$logins->delete()) {
						return false;
					}
				}
			}

			if ($this->profilePic != null) {
				if (!$this->profilePic->delete()) {
					return false;
				}
			}
			
			
			
			/*
			 * in considering the message or other things may refer to a user, 
			 * it is not allowed to be deleted. 
			 */
			$this->password = $this->salt;
			$this->email = "deleted".$this->id."@zloop.net";
			$this->username = "D";
			$this->address = "D";
			$this->profilePic = 0;
			$this->phone = "D";
			$this->create_time = -1;
			$this->save(false);
			return false;
			
		} else
		return false;
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function moveToWaitConfirm()
	{
		$deletedModel = User_D::model();
		$deletedModel->forceDelete = true;
		$deletedModel->deleteAll(
			"email = :email",
			array(':email'=>$this->email)
		);
		
		$this->deleteForRegistration = true;
		$this->delete();
	}
	
	public function findByEmail($email) {
		$email = strtolower($email);
		return ($this->find('LOWER(email)=?',array($email)));
	}
	
	public function getGeneralLink( $s ) {
		$linkString = CHtml::link($s, array('/user/view', 'id'=>$this->id));
		return($linkString);
	}
	
	public function getNameLink()
	{
		$linkString = CHtml::link(CHtml::encode($this->username), array('/user/view', 'id'=>$this->id));
		return($linkString);
	}
	
	public function getNameBold()
	{
		$s = "<b>".$this->username."</b>";
		return($s);
	}
}
