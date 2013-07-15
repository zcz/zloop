<?php

require_once("migrations/DoubleMigration.php");

class m110917_073820_create_friend_table extends DoubleMigration
{
	public $table_name = "friend";
	public $para = array(
			"id"=>"pk",
			"fromid"=>"INT(11) NOT NULL",
			"toid"=>"INT(11) NOT NULL",
		);
}
