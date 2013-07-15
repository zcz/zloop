<?php


class FacebookController extends ZLOOPController
{
	
	private $facebook;
	private $login_url;
	private $api_get_profile_pic;
	private $user_id;

	public function filters() {
		return array('accessControl', );
	}
	
	public function accessRules() {
		return array( // allow all users to login AS facebook
			array('allow', 'actions'=>array('login','index'),'users'=>array('*'), ),
			array('deny', 'users'=>array('*'), ),
		);
	}
	
	
	public function prepareFacebook() {
		$faceBase = dirname(__FILE__).'/../extensions/facebook/php-sdk/src/facebook.php';
		require_once $faceBase;
		
		//facebook login accout
		$this->facebook = new Facebook(array(
			  'appId'  => '202321366523553',
			  'secret' => '554aadd5d5f6d82a55986df1706f1548',
			  'fileUpload' => false,
		));
		
		$this->user_id = $this->facebook->getUser();
		
		//log in request, request email,
		$this->login_url = $this->facebook->getLoginUrl( array(
			'scope' => 'email,user_birthday,status_update,publish_stream',
			'display' => 'page',
		));
		
		$this->api_get_profile_pic = array(
				'method' => 'users.getinfo',
			    'uids' => $this->user_id,  
				'fields' => 'pic_big',
		);
	}
		
	
	public function actionIndex() {
		echo "I am here";
	}
	
	
	public function actionLogin() {
		
		$this->prepareFacebook();
		
		//echo "user_id = $this->user_id <br>";

		if($this->user_id) {
			try {

				$user_profile = $this->facebook->api('/me','GET');
				//echo "Name: " . $user_profile['name'] . '<br>';
				//echo "Email: " . $user_profile['email'] . '<br>';
				$accesstoken = $this->facebook->getAccessToken();
				//echo "access token: " . $accesstoken . "<br>";

				$info = $this->facebook->api($this->api_get_profile_pic);
				$info = $info[0]; 
				$infoUrl = $info['pic_big'];
				//echo "pic: " . $info['pic_big'] . '<br>';	

				if (Extlogin::model()->getAccountFromFacebook($this->user_id)) {
					Yii::log('facebook login, email:' . $user_profile['email']);
					$this->redirect(array("site/index"));
				} else {
					Yii::log("facebook sign up, email:" . $user_profile['email'] . ", facebook_uid: " . $this->user_id);

					$user = User::model()->findByEmail($user_profile['email']);
					if ($user == null)
					{
						Yii::log("new user, create User, email:" . $user_profile['email'] . ", facebook_uid: " . $this->user_id . ", profile picture url: " . $infoUrl);
						
						$user = new User("create");
						$user->email = $user_profile['email'];
						$user->username = $user_profile['name'];
						$user->password = $user->genRandomCode();
						$user->encode_password = true;
						$user->save(false);
						
						$pic = new Pic;
						$url = urldecode($infoUrl);
						$pic->data = @file_get_contents($url);
						if (strpos($http_response_header[0], "200")) {
							$pic->itemid = 0;
							$pic->story = "profile from facebook";
							$pic->save();
							$user->profilepicid = $pic->getPrimaryKey();
							$user->save(false, array('profilepicid'));
							$picId = $pic->id;
							Yii::log("user profile picture added, picId=$picId");
							Yii::log("pic [id:".$pic->getPrimaryKey()."] added from facebook as user profile, url = $url");			
							echo "SUCCESS";
						} else {
							Yii::log("pic add from facebook failed, url = $url");
							echo "FAILED";
						}
					} else {
						Yii::log("user existed, searched by email");
					}
					

					$faceAcc = new Extlogin("create");
					$faceAcc->userid = $user->getPrimaryKey();
					$faceAcc->socialnetworkname = "facebook";
					$faceAcc->extid = $this->user_id;
					$faceAcc->accesstoken = $accesstoken;
					$faceAcc->save();
					
					$this->redirect(array("facebook/login"));
				}

			} catch(FacebookApiException $e) {
				// If the user is logged out, you can have a
				// user ID even though the access token is invalid.
				// In this case, we'll get an exception, so we'll
				// just ask the user to login again here.
				//echo 'Please <a href="' . $this->login_url . '">login.</a>';
				$this->redirect($this->login_url);
				error_log($e->getType());
				error_log($e->getMessage());
			}
		} else {

			// No user, print a link for the user to login
			// echo 'Please <a href="' . $this->login_url . '">login.</a>';
			$this->redirect($this->login_url);
		}
	}
	
}