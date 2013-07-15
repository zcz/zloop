<?php

/**
 * This is the model class for table "extlogin".
 *
 * The followings are the available columns in table 'extlogin':
 * @property integer $id
 * @property integer $userid
 * @property string $socialnetworkname
 * @property string $extid
 * @property string $accesstoken
 * @property string $description
 * @property string $moreinfo
 * @property integer $create_time
 */
class Extlogin extends SafeActiveRecord
{
	private $_identity;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Extlogin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{extlogin}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'user'=>array(self::BELONGS_TO, 'User', 'userid' ),
		);
	}
		
	public function getAccountFromFacebook( $user_id ) {
		$login = Extlogin::model()->find('extid=? AND socialnetworkname=?',array($user_id, "facebook"));
		if ($login != null) {
			$user = $login->user;
			if ($this->_identity === null)
			{
				$this->_identity = new UserIdentity($user->email, $user->password);
				$this->_identity->setExternalAuthenticate(true);
				$this->_identity->authenticate();
			}
			if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
			{
				$duration=3600*24; // 30 days
				Yii::app()->user->login($this->_identity,$duration);
				return( true );
			} else {
				echo $this->_identity->errorCode;
			}
		}
		
		return( false );
	}
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->create_time=time();
			}
			return(true);
		}
		else
		return false;
	}
}