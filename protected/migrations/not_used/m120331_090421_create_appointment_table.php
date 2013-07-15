<?php

require_once("migrations/DoubleMigration.php");

class m120331_090421_create_appointment_table extends DoubleMigration
{
	public $table_name = "appointment";
	public $para = array(
		"id"=>"pk",
		"parentid"=>"INT(11) DEFAULT 0",
		"itemid"=>"INT(11)",
		"fromuserid"=>"INT(11) NOT NULL",
		"touserid"=>"INT(11) NOT NULL",
		"meetingtime"=>"integer NOT NULL",
		"meetingaddress"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci NOT NULL",
		"notes"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
		"reply"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
		"confirmed"=>"BOOL DEFAULT FALSE",
		"create_time"=>"integer NOT NULL",				//time that this appointment created
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