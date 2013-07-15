<?php

require_once("migrations/DoubleMigration.php");

class m111027_142425_create_tagItem_table extends DoubleMigration
{
	public $table_name = "tagItem";
	public $para = array(
	        "id"=>"pk",
			"tagid"=>"INT(11) NOT NULL",
			"itemid"=>"INT(11) NOT NULL",
		);
	
}