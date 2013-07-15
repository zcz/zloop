<?php

require_once("migrations/DoubleMigration.php");

class m120219_131748_create_userviewitem_table extends DoubleMigration
{
	public $table_name = "userviewitem";
	public $foreign_user = "user";
	public $foreign_item = "item";
	public $para = array(
			"id"=>"pk",
			"userid"=>"INT(11) NOT NULL",					//foreign key with user table
			"itemid"=>"INT(11) NOT NULL",					//foreign key with item table
			"view_time"=>"integer",							//time that this user account created
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