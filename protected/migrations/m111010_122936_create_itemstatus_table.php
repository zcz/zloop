<?php

require_once("migrations/DoubleMigration.php");

class m111010_122936_create_itemstatus_table extends DoubleMigration
{
	public $table_name = "itemstatus";
	public $para = array(
            "id"=>"pk",
			"lastview"=>"integer DEFAULT 0",
			"lastcomment"=>"integer DEFAULT 0",
			"lastreply"=>"integer DEFAULT 0",
			"viewnum"=>"integer DEFAULT 0",
			"itemid"=>"INT(11) NOT NULL DEFAULT 0",
		);
}