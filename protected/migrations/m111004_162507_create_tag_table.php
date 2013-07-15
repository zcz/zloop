<?php

/**
 * this is the table for tag function, 
 * worked with table: tagUser, tagItem
 * the information here stands for the 
 * globle statistics, and the information
 * in the tagUser stands for the particular 
 * information of that user. 
 */

require_once("migrations/DoubleMigration.php");

class m111004_162507_create_tag_table extends DoubleMigration
{
	public $table_name = "tag";
	public $para = array(
	        "id"=>"pk",
			"tagName"=>"string CHARACTER  SET utf8 COLLATE utf8_unicode_ci NOT NULL",
			"numview"=>"integer DEFAULT 0",
			"numused"=>"integer DEFAULT 0",
			"create_time"=>"integer NOT NULL",
		);
}