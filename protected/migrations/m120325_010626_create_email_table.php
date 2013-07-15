<?php

require_once("migrations/DoubleMigration.php");

class m120325_010626_create_email_table extends DoubleMigration
{
	public $table_name = "email";
	public $para = array(
			"id"=>"pk",
			"fromemail" => "VARCHAR(255)",
			"toemail" => "VARCHAR(255) NOT NULL",
			"title" => "text CHARACTER  SET utf8 COLLATE utf8_unicode_ci NOT NULL",
			"body" => "text CHARACTER  SET utf8 COLLATE utf8_unicode_ci NOT NULL",
			"create_time"=>"integer",							//time that this user account created
		);
	
	public function up() {
	//create table and foreign key	
		parent::up();
		//$this->addForeignKey( "fk_userviewitem_user","{{".$this->table_name."}}","userid","{{".$this->foreign_user."}}","id","CASCADE","CASCADE" );
		//$this->addForeignKey( "fk_userviewitem_item","{{".$this->table_name."}}","itemid","{{".$this->foreign_item."}}","id","CASCADE","CASCADE" );
	}
	
	public function down()  {
		//$this->dropForeignKey( "fk_userviewitem_user","{{".$this->table_name."}}" );
		//$this->dropForeignKey( "fk_userviewitem_item","{{".$this->table_name."}}" );
		parent::down();
	}
}