<?php

require_once("migrations/DoubleMigration.php");

class m110917_120532_create_attach_table extends DoubleMigration
{
	public $table_name = "attach";
	public $para = array(
            "id"=>"pk",
			"itemid"=>"INT(11) NOT NULL",
			"last_modified"=>"integer",
			"data"=>"LONGBLOB NOT NULL",
			"icon"=>"LONGBLOB NOT NULL",
			"title"=>"string CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
			"story"=>"string CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
		);
}
