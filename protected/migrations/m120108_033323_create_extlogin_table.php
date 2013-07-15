<?php

require_once("migrations/DoubleMigration.php");

class m120108_033323_create_extlogin_table extends DoubleMigration
{
	
	public $table_name = "extlogin";
	public $foreign_table_name = "user";
	public $para = array(
			"id"=>"pk",
			"userid"=>"INT(11) NOT NULL",											//foreign key with user table
			"socialnetworkname"=>"string CHARACTER  SET utf8 COLLATE utf8_unicode_ci NOT NULL",
			"extid"=>"string NOT NULL",
			"accesstoken"=>"string NOT NULL",
			"description"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
			"moreinfo"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
			"create_time"=>"integer",												//time that this user account created
		);
	
	public function up() {
	//create table and foreign key	
		parent::up();
		//$this->addForeignKey( "fk_extlogin_user","{{".$this->table_name."}}","userid","{{".$this->foreign_table_name."}}","id","CASCADE","CASCADE" );
		
	}
	
	public function down()  {
		//$this->dropForeignKey( "fk_extlogin_user","{{".$this->table_name."}}" );
		parent::down();
	}
}