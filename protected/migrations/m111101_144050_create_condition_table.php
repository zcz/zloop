<?php

require_once("migrations/DoubleMigration.php");

class m111101_144050_create_condition_table extends DoubleMigration
{
	public $table_name = "condition";
	public $real_name = null; //will be generated from DoubleMigration
	public $para = array(
			"id"=> "INT NOT NULL PRIMARY KEY",
			"parentid"=>"INT(11) NOT NULL",
			"title"=>"string CHARACTER  SET utf8 COLLATE utf8_unicode_ci NOT NULL",
			"detail"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
		);
	
	public function up()
	{
		parent::up();
		
		$list = array(
			array("id"=>  000, "parentid"=>000, "title"=>"All Conditions"),
			 
			array("id"=>  001, "parentid"=>000, "title"=>"For Sale"),
			array("id"=>  101, "parentid"=>001, "title"=>"New"),
			array("id"=>  102, "parentid"=>001, "title"=>"Used"),
			array("id"=>  103, "parentid"=>001, "title"=>"For parts or not working"),
			
			array("id"=>  002, "parentid"=>000, "title"=>"Not For Sale"),
			array("id"=>  201, "parentid"=>002, "title"=>"Sold"),
			array("id"=>  202, "parentid"=>002, "title"=>"For Share"),
			//array("id"=>  203, "parentid"=>002, "title"=>"Expired"), done in the migration: m120916_024540_update_T_item_ADD_expireTime
		);

		foreach ($list as $one)
		{
			$this->execute("INSERT INTO $this->real_name (id, parentid, title) VALUES (:id, :parentid, :title )", 
			  array(":id"=>$one["id"], ":parentid"=>$one["parentid"], ":title"=>$one["title"]) );
		}
	}
}