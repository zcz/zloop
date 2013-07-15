<?php

class m120916_024540_update_T_item_ADD_expireTime extends CDbMigration
{	
	/*
	 * add one column in table Item, "expire_time"
	 */
	public function modifyTableItem() {
		$table_name = 'item';
		$dummy_name = $table_name;
		$real_name = 'tb_' . $table_name;
		
		$this->doIt($dummy_name);
		$this->doIt($real_name);
	}
	public function doIt($table) {
		$this->addColumn($table, "expire_time", "integer NOT NULL");
		$this->addColumn($table, "conditionbackup", "INT(11) NOT NULL");
		$this->addColumn($table, "expire_email_flag_time", "integer default 0");
	}
	
	/*
	 * add one more condition "Expired" in Condition table
	 */
	public function modifyTableCondition() {
		$tableName = 'tb_condition';
		
		$one = array("id"=>  203, "parentid"=>002, "title"=>"Expired"); //done in the migration: m120916_024540_update_T_item_ADD_expireTime
	
		$this->execute("INSERT INTO $tableName (id, parentid, title) VALUES (:id, :parentid, :title )", array(":id"=>$one["id"], ":parentid"=>$one["parentid"], ":title"=>$one["title"]) );
	}
	
	/*
	 * update the item's expire time, to be in the five days
	 */
	public function updateTableItem() {
		$keyWord = new SearchKeysForm;
		$items = Goods::model()->searchItems($keyWord);
		
		foreach ($items as $item) {
			$item->conditionbackup = $item->conditionid;
			/*
			 * expire in the next five days
			 */
			$item->expire_time = time() + 60 * 60 * 24 * 5;
			$item->save(false, array("conditionbackup", "expire_time") );
		}
	}
	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp() {
		$this->modifyTableItem();
		$this->modifyTableCondition();
		$this->updateTableItem();
	}

	public function safeDown()
	{
		echo "m120916_024540_update_T_item_ADD_expireTime does not support migration down.\n";
		//return false;	
	}	
}