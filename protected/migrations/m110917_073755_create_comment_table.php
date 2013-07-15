<?php

require_once("migrations/DoubleMigration.php");

class m110917_073755_create_comment_table extends DoubleMigration
{
	public $table_name = "comment";
	public $para = array(
            "id"=>"pk",
			"content"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci NOT NULL",
			"reply"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
			"create_time"=>"integer",
			"reply_time"=>"integer default 0",
			"check_time"=>"integer default 0",
			"itemid"=>"INT(11) default 0",
			"userid"=>"INT(11) NOT NULL",
			'isprivate'=>'boolean default FALSE',
		);
}
