<?php

class UserBase extends SafeActiveRecord
{
	/*
	 * used for delete item, also for control registration flow. 
	 */	
	public $deleteForRegistration = false;
	
	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->password;
	}
	
	public function hashPassword($password,$salt)
	{
		return md5($salt.$password);
	}
	
	public function getCodeForEmail()
	{
		return md5($this->salt.$this->password.$this->id.$this->email);
	}
	
	public function genRandomCode() {
		$passwordString = (rand() * rand() + rand() ) % 1000000 + "";
		while( strlen($passwordString) < 6 ) {
			$passwordString .= rand() % 10;
		}
		return ($passwordString);
	}
	
	/**
	 * used by send confirm email, to activate the email 
	 */
	public function getConfirmUrl() {
		return $this->getEmailActionLink('email/emailConfirm');
	}
	
	/**
	 * get link to change password
	 */
	public function getForgetPasswordUrl() {
		return $this->getEmailActionLink('email/changePassword');
	}
	
	/**
	 * used by send confirm email, for error sending  
	 */
	public function getNotMeUrl()
	{
		return $this->getEmailActionLink('email/errorSendEmail');
	}
	
	/**
	 * unsubscribe for weekly news email
	 */
	public function getUnsubcribeUrl() {
		return $this->getEmailActionLink("email/unsubscribeWeeklyNews");
	}
	
	public function getEmailActionLink($s) {
		return 
			$this->getFullAndSafeUrl($s, 
				array(
					'id'=>$this->id, 
					'code'=>$this->getCodeForEmail() 
				)
			);
	}
	
	public function getBaseSiteUrl() {
		return $this->getFullAndSafeUrl("");
	}
}