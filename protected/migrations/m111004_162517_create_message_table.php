<?php

require_once("migrations/DoubleMigration.php");

class m111004_162517_create_message_table extends DoubleMigration
{
	public $table_name = "message";
	public $para = array(
	        "id"=>"pk",
			"fromid"=>"INT(11) NOT NULL",
			"toid"=>"INT(11) NOT NULL",
			"content"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci NOT NULL",
			"parentid"=>"INT(11) NOT NULL",												//used to find all the messages on one thread
			"create_time"=>"integer",
			"check_time"=>"integer default 0",
			'isprivate'=>'boolean default FALSE',
		);
}