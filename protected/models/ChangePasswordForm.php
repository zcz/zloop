<?php

class ChangePasswordForm extends CFormModel
{
	public $oldPassword;
	public $password;
	public $password_repeat;

	private $_identity;
	public $user;
	public $passwordHash;
	public $passwordChanged = false;
	
	public function rules()
	{
		return array(
			array('password, password_repeat, oldPassword', 'required'),
			array('oldPassword', 'authenticate'),
			array('password', 'compare', 'strict'=>true),
		);
	}

	public function attributeLabels()
	{
		return array(
			'oldPassword'=>'Old Password',
			'password'=>'New Password',
			'password_repeat'=>'Repeat Password'
		);
	}

	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->user->email, $this->oldPassword);
			if(!$this->_identity->authenticate())
			{
				$this->addError('oldPassword','Incorrect old password.');
			}
			else
			{
				$this->passwordHash = $this->user->hashPassword($this->password, $this->user->salt);
			}
		}
	}

	
}
