<?php

require_once("migrations/DoubleMigration.php");

class m111004_145442_create_category_table extends DoubleMigration
{
	public $table_name = "category";
	public $real_name = null; //will be generated from DoubleMigration
	public $para = array(
			"id"=> "INT NOT NULL PRIMARY KEY",
			"parentid"=>"INT(11) NOT NULL",
			"title"=>"string CHARACTER  SET utf8 COLLATE utf8_unicode_ci NOT NULL",
			"detail"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
			"template"=>"text CHARACTER  SET utf8 COLLATE utf8_unicode_ci",
			"frequency"=>"integer",
			"order"=>"integer",
		);
	
	public function up()
	{
		parent::up();
		
		$list = array(
		//the root category
		array("id"=>000, "parentid"=>000,
			"title"=>"All Categories"),

			
		//Textbook category
		array("id"=>001,	"parentid"=>000,
			"title"=>"Books"),
		array("id"=>101,	"parentid"=>001,
			"title"=>"Arts & Design"),
		array("id"=>102,	"parentid"=>001,
			"title"=>"Business"),
		array("id"=>103,	"parentid"=>001,
			"title"=>"Engineering"),
		array("id"=>104,	"parentid"=>001,
			"title"=>"Humanities"),
		array("id"=>105,	"parentid"=>001,
			"title"=>"Science"),
		array("id"=>106,	"parentid"=>001,
			"title"=>"Fiction & Literature"),
		array("id"=>107,	"parentid"=>001,
			"title"=>"Magazines"),
		array("id"=>108,	"parentid"=>001,
			"title"=>"Notes & Papers"),		
		array("id"=>109,	"parentid"=>001,
			"title"=>"Others"),
		
		//entertainment category
		array("id"=>002,	"parentid"=>000,
			"title"=>"Entertainment"),
		array("id"=>201,	"parentid"=>002,
			"title"=>"CDs & DVDs"),
		array("id"=>202,	"parentid"=>002,
			"title"=>"Video Games"),
		array("id"=>203,	"parentid"=>002,
			"title"=>"Animation & Comics"),
		array("id"=>204,	"parentid"=>002,
			"title"=>"Others"),
		
		//electronics category
		array("id"=>003,	"parentid"=>000,
			"title"=>"Electronics"),
		array("id"=>301,	"parentid"=>003,
			"title"=>"Computers"),
		array("id"=>302,	"parentid"=>003,
			"title"=>"Cell phones"),
		array("id"=>303,	"parentid"=>003,
			"title"=>"TV, Video & Audio"),
		array("id"=>304,	"parentid"=>003,
			"title"=>"Cameras & Photo"),
		array("id"=>305,	"parentid"=>003,
			"title"=>"Accessories"),
		array("id"=>306,	"parentid"=>003,
			"title"=>"Others"),

		//Cosmetics
		array("id"=>004,	"parentid"=>000,
			"title"=>"Cosmetics"),
		array("id"=>401,	"parentid"=>004,
			"title"=>"Makeup"),
		array("id"=>402,	"parentid"=>004,
			"title"=>"Perfume"),
		array("id"=>403,	"parentid"=>004,
			"title"=>"Skin care"),
		array("id"=>404,	"parentid"=>004,
			"title"=>"Hair care"),
		array("id"=>405,	"parentid"=>004,
			"title"=>"Nail care"),
		array("id"=>406,	"parentid"=>004,
			"title"=>"Others"),
		
		//fashion and clothes
		array("id"=>005,	"parentid"=>000,
			"title"=>"Fashion & Clothes"),
		array("id"=>501,	"parentid"=>005,
			"title"=>"Formal suits"),
		array("id"=>502,	"parentid"=>005,
			"title"=>"Formal dresses"),
		array("id"=>503,	"parentid"=>005,
			"title"=>"Accessories"),
		array("id"=>504,	"parentid"=>005,
			"title"=>"Casual"),
		array("id"=>505,	"parentid"=>005,
			"title"=>"Shoes"),
		array("id"=>506,	"parentid"=>005,
			"title"=>"Others"),
			
		array("id"=>006,	"parentid"=>000,
			"title"=>"Household Goods"),
		array("id"=>601,	"parentid"=>006,
			"title"=>"Furnitures"),
		array("id"=>602,	"parentid"=>006,
			"title"=>"Household Appliances"),
		array("id"=>603,	"parentid"=>006,
			"title"=>"Others"),
			
		array("id"=>007,	"parentid"=>000,
			"title"=>"Arts & Sports"),
		array("id"=>701,	"parentid"=>007,
			"title"=>"Musical Instruments"),
		array("id"=>702,	"parentid"=>007,
			"title"=>"Sports equipment"),
		array("id"=>703,	"parentid"=>007,
			"title"=>"Handcrafts & Models"),
		array("id"=>704,	"parentid"=>007,
			"title"=>"Toys & Hobbies"),
		array("id"=>705,	"parentid"=>007,
			"title"=>"Others"),
		
		array("id"=>8,	"parentid"=>0,
			"title"=>"Others"),
		array("id"=>801,	"parentid"=>8,
			"title"=>"Stationery"),
		array("id"=>802,	"parentid"=>8,
			"title"=>"Collectible"),
		array("id"=>803,	"parentid"=>8,
			"title"=>"Others"),
		);

		foreach ($list as $one)
		{
			$this->execute("INSERT INTO $this->real_name (id, parentid, title) VALUES (:id, :parentid, :title )", 
			  array(":id"=>$one["id"],  ":parentid"=>$one["parentid"], ":title"=>$one["title"]) );
		}
	}
}