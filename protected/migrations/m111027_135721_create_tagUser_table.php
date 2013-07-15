<?php

require_once("migrations/DoubleMigration.php");

class m111027_135721_create_tagUser_table extends DoubleMigration
{
	public $table_name = "tagUser";
	public $para = array(
	        "id"=>"pk",
			"tagid"=>"INT(11) NOT NULL",
			"userid"=>"INT(11) NOT NULL",
			"numview"=>"integer DEFAULT 0",
			"numused"=>"integer DEFAULT 0",
		);
}