<?php

require_once("migrations/DoubleMigration.php");

class m110917_073651_create_item_table extends DoubleMigration
{
	public $table_name = "item";
	public $para = array(
            "id"=>"pk",
			"title"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci NOT NULL",
			"pricelow"=>"integer",
			"pricehigh"=>"integer",
			"content"=>"mediumtext CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
			"presentation"=>"mediumtext CHARACTER  SET utf8 COLLATE utf8_unicode_ci",   //the presentation from editor, will generate summary and content
			"summary"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci",				//a small piece of words, from content
			"tagString"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
			"create_time"=>"integer",
			//"expire_time"=>"integer",													//this will be added in migration: m120916_024540_update_T_item_ADD_expireTime
			//"expire_email_flag_time"=>"integer",										//this will be added in migration: m120916_024540_update_T_item_ADD_expireTime
			"last_modified"=>"integer",
			"userid"=>"INT(11) NOT NULL",
			"categoryid"=>"INT(11) NOT NULL",											//foreign key on category table
			"conditionid"=>"INT(11) NOT NULL", 											//foreign key for item condition
			//"conditionbackup"=>"INT(11) NOT NULL", 									//foreign key for item condition back up, save the last valid condition, will be added in migration: m120916_024540_update_T_item_ADD_expireTime
			"statusid"=>"INT(11) NOT NULL",
		);
}
