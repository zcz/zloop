<?php
class UserIdentity extends CUserIdentity
{
    private $_id;
    private $_email;
    
    private $_externalAuthenticate = false;
 
    public function authenticate()
    {
    	if ($this->_externalAuthenticate){
    		return($this->externalAuthenticate());
    	}
    	
        $username=strtolower($this->username);
        $user=User::model()->find('LOWER(email)=?',array($username));
        if($user===null) {
        	$this->errorCode=self::ERROR_USERNAME_INVALID;
        	$this->errorMessage = "The email does not belong to any account.";
        }
        else if(!$user->validatePassword($this->password)) {
        	$this->errorCode=self::ERROR_PASSWORD_INVALID;
        	$this->errorMessage = "The password you entered was not valid.";
        }
        else{
        	$this->passAndSetAttributes( $user );
        }
        return $this->errorCode==self::ERROR_NONE;
    }
    
    public function externalAuthenticate() {
 		//echo "externalAnthenticate reached";
    	if ($this->_externalAuthenticate == false) {
    		$this->errorCode=self::ERROR_USERNAME_INVALID;
    	} else {
    		$user = User::model()->findByEmail($this->username);
    		if ($user===null) {    			
    			$this->errorCode=self::ERROR_USERNAME_INVALID;
    		} else {
    			$this->passAndSetAttributes( $user );
    		}
    	}
    	
    	return $this->errorCode==self::ERROR_NONE;
    }
    
    private function passAndSetAttributes( $user ) {
    	$this->_id=$user->id;
    	$this->username=$user->username;
    	$this->_email=$user->email;
    	$this->errorCode=self::ERROR_NONE;
    }
 
    public function getId()
    {
        return $this->_id;
    }
  
    public function getEmail()
    {
        return $this->_email;
    }
    
    public function setExternalAuthenticate( $yesOrNo ) {
    	$this->_externalAuthenticate = $yesOrNo;
    }
    
}
