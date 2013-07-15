<?php

require_once("migrations/DoubleMigration.php");

class m110917_073629_create_user_table extends DoubleMigration
{
	public $table_name = "user";
	public $real_name = null; //will be generated from DoubleMigration
	public $para = array(
			"id"=>"pk",
			"email"=>"string NOT NULL",
			"username"=>"string CHARACTER  SET utf8 COLLATE utf8_unicode_ci NOT NULL",
			"password"=>"string NOT NULL",
			"salt"=>"string NOT NULL",														//used for password md5, random generated
			"address"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
			"phone"=>"string",
			"ifNotify"=>"integer DEFAULT 1",
			"sendWeeklyEmail"=>"integer DEFAULT 1", 										//used to control weekly news sending
			"nextNotify"=>"integer DEFAULT 0",											//the last notified time, which is 
			"intervalNotify"=>"integer DEFAULT 86400", 								//time for notification intervals, default one day
			"create_time"=>"integer",												//time that this user account created
			"last_modified"=>"integer",													//last log in time, used to calculate the total online time
 			"profilepicid"=>"INT(10) DEFAULT 0",
		);
	
	public function up()
	{
		parent::up();
	
		$list = array(
			array(
				"email"=>"admin", 
				"username"=>"admin", 
				"password"=>"e00995154246052708eb228f12c561af", 
				"salt"=>"4eb25cb65ea424eb25cb65ea99"
			),
			array(
				"email"=>"demo", 
				"username"=>"demo", 
				"password"=>"e8141077c5e379d9a013cc6dbc430f34", 
				"salt"=>"4eb25d4574d784eb25d4574dc4"
			),
		);
		
		foreach ($list as $one)
		{
			$s = "INSERT INTO $this->real_name";
			$s .= " (email, username, password, salt) ";
			$s .= "VALUES ( :email, :username, :password, :salt ) ";
			$this->execute( $s, array(
				":email"=>$one["email"], 
				":username"=>$one["username"],
				":password"=>$one["password"],
				":salt"=>$one["salt"],
			));
		}
	}
	
}
