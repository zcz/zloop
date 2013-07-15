<?php

/**
 * remove all foreign keys, because they work in innodb...
 * and I don't want them work.
 * @author zcz
 *
 */

class m121004_170342_create_foreign_keys extends CDbMigration
{
	public function safeUp()
	{
		//$this->addForeignKey( "fk_friend_user_from", "{{friend}}", 	 	"fromid",      "{{user}}",      "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_friend_user_to",   "{{friend}}", 	 	"toid"  ,      "{{user}}",      "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_item_user",        "{{item}}",   	 	"userid",      "{{user}}",      "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_comment_item",     "{{comment}}",	 	"itemid",      "{{item}}",      "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_comment_user",     "{{comment}}",	 	"userid",      "{{user}}",      "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_attach_item",      "{{attach}}",    	"itemid",      "{{item}}",      "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_item_category",    "{{item}}",   		"categoryid",  "{{category}}",  "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_msg_user_from", 	 "{{message}}", 	"fromid",      "{{user}}",      "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_msg_user_to",   	 "{{message}}", 	"toid",        "{{user}}",      "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_msg_msg",          "{{message}}", 	"parentid",    "{{message}}",   "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_status_item",   	 "{{itemstatus}}", 	"itemid"  ,    "{{item}}",      "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_tagUser_user",	 "{{tagUser}}",	 	"userid",      "{{user}}",      "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_tagItem_item",     "{{tagItem}}",	 	"itemid",      "{{item}}",      "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_tagUser_tag",      "{{tagUser}}",	 	"tagid",       "{{tag}}",       "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_tagItem_tag",      "{{tagItem}}",	 	"tagid",       "{{tag}}",       "id", "CASCADE", "CASCADE" );
		//$this->addForeignKey( "fk_item_condition",   "{{item}}",   		"conditionid", "{{condition}}", "id", "CASCADE", "CASCADE" );
		//category to category, parent relation
		//$this->addForeignKey( "fk_ctg_ctg", 		 "{{category}}", 	"parentid",    "{{category}}",  "id", "CASCADE", "CASCADE" );
		//condition to condition, parent relation
		//$this->addForeignKey( "fk_cdt_cdt", 		 "{{condition}}", 	"parentid",    "{{condition}}", "id", "CASCADE", "CASCADE" );
	}

	public function safeDown()
	{
		//$this->dropForeignKey( "fk_friend_user_from", "{{friend}}"     );
		//$this->dropForeignKey( "fk_friend_user_to",   "{{friend}}"     );
		//$this->dropForeignKey( "fk_item_user",        "{{item}}"       );
		//$this->dropForeignKey( "fk_comment_item",     "{{comment}}"    );
		//$this->dropForeignKey( "fk_comment_user",     "{{comment}}"    );
		//$this->dropForeignKey( "fk_attach_item", 	  "{{attach}}"     );
		//$this->dropForeignKey( "fk_item_category",    "{{item}}"       );
		//$this->dropForeignKey( "fk_msg_user_from",    "{{message}}"    );
		//$this->dropForeignKey( "fk_msg_user_to",      "{{message}}"    );
		//$this->dropForeignKey( "fk_msg_msg",          "{{message}}"    );
		//$this->dropForeignKey( "fk_status_item",   	  "{{itemstatus}}" );
		//$this->dropForeignKey( "fk_tagUser_user",	  "{{tagUser}}"	   );
		//$this->dropForeignKey( "fk_tagItem_item",     "{{tagItem}}"	   );
		//$this->dropForeignKey( "fk_tagUser_tag",      "{{tagUser}}"    );
		//$this->dropForeignKey( "fk_tagItem_tag",      "{{tagItem}}"    );
		//$this->dropForeignKey( "fk_item_condition",   "{{item}}"	   );
		//category to category, parent relation
		//$this->dropForeignKey( "fk_ctg_ctg", 		 "{{category}}"    );
		//condition to condition, parent relation
		//$this->dropForeignKey( "fk_cdt_cdt", 		 "{{condition}}"   );
	}
}
