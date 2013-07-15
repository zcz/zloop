<?php

/**
 * forgetPasswordForm class.
 * forgetPasswordForm is the data structure for keeping
 * forgetPassword form data. It is used by the 'forgetPassword' action of 'SiteController'.
 */
class ForgetPasswordForm extends CFormModel
{
	public $email;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('email', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			// email must be an existing one in db
			array('email', 'inDB'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}
	
	/**
	* check email existed in db
	*/
	public function inDB($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$user = User::model()->findByEmail($this->email);
			if($user == null)
			$this->addError('email','Email not found in zloop, you may create a new account.');
		}
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
		);
	}
}