<?php

class SafeActiveRecord extends CActiveRecord
{
	//used to delete the records, only if it is true and the record has $isdelete=true;
	//then the record in database will be deleted
	public $forceDelete = false;
	public $deleted = false;
	
	
	public function getFullAndSafeUrl($path = "", $par = Array(), $encode = false) {
		
		//return($path);

		$portString = Yii::app()->params['sitePort'];
		//$portString = "80";
		$findString = "zloop.net";
		//cause server changed, 80 port is accessble now, no need to change to 1503
		$fullString = $findString;
		//$fullString = $findString . ":" . $portString;
	
		$pattern = '/zloop\.net(:\d+)?/';
	
		//$subject = "http://www.zloop.net/index.php?r=item/view&id=3";
		
		if (isset($_SERVER['SERVER_NAME'])) {
			$subject = Yii::app()->createAbsoluteUrl($path, $par);
		} else {
			$subject = Yii::app()->createUrl($path, $par);
		}
		//echo "$subject\n";
		$findItYIIC = "/(.)*\/yiic/";
		$replaceYIIC = "http://www.zloop.net/index.php";
		//echo "$subject\n";
		$subject = preg_replace($findItYIIC, $replaceYIIC, $subject, 1);
		
		$subject = preg_replace($pattern, $fullString, $subject, 1);
		
		if ($encode == true) {
			$subject = urlencode($subject);
		}
		return($subject);
	}
	
	/**
	 * rewrite the delete function to support
	 * not actually delete fucntion
	 */
	public function delete()
	{
		$nameOfTable = str_replace(array("{","}"), "", $this->tableName());
		$uid = $this->getPrimarykey();

		if(!$this->getIsNewRecord())
		{
			Yii::trace(get_class($this).'.delete()','system.db.ar.CActiveRecord');
			if($this->beforeDelete())
			{
				if ($this->deleted==false)
				{
					//Yii::log("deleted, moved: $nameOfTable : $this->id");

					$nameOfTable = str_replace(array("{","}"), "", $this->tableName());
					$uid = $this->getPrimarykey();

					$baseDB = Yii::app()->db->tablePrefix.$nameOfTable;
					$targetDB = $nameOfTable;

					$result=$this->dbMove($baseDB, $targetDB, $uid);

					$this->afterDelete();
					return $result;
				} else
				{
					if ($this->forceDelete == false)
					{
						return false;
					}

					//Yii::log("really deleted: $nameOfTable : $this->id");
					$result=$this->deleteByPk($this->getPrimaryKey())>0;
					return($result);	
				}
			}
			else
			return false;
		}
		else
		throw new CDbException(Yii::t('yii','The active record cannot be deleted because it is new.'));
	}
	
	/**
	 * Copy a row from one table to another: table->tb_table or tb_table->table 
	 * 
	 * Called by $this->dbMove
	 */
	private function dbCopy($fromTable, $toTable, $uid)
	{
		$connection = Yii::app()->db;

		$sql  = "DELETE FROM `".$toTable."` ";
		$sql .= "WHERE `id` = ".$uid;
				
		$command=$connection->createCommand($sql);
		$rowCount=$command->execute();
		//Yii::log("DELETE FOR OLD TABLE: ".$sql." DELETED: " .$rowCount);
		
		
		$connection = Yii::app()->db;
		
		$sql  = "INSERT `".$toTable."` ";
		$sql .= "SELECT * FROM `".$fromTable."` ";
		$sql .= "WHERE `id` = ".$uid;
		
		//Yii::log("move: ".$sql);

		$command=$connection->createCommand($sql);
		$rowCount=$command->execute();
		return ($rowCount);
	}
	
	/**
	 * first copy and then delete a row from one table to another
	 * 
	 * called by delete, reverse
	 */
	private function dbMove($fromTable, $toTable, $uid)
	{
		$copyNum = $this->dbCopy($fromTable, $toTable, $uid);
		if ($copyNum != 0)
		{
			$result=$this->deleteByPk($uid)>0;
		} else {
			$result = false;
		}
		return $result;
	}
	
	public function reverseDelete()
	{
		if ($this->deleted === false) return false;
		
		$nameOfTable = str_replace(array("{","}"), "", $this->tableName());
		
		$uid = $this->getPrimarykey();
		$targetDB= Yii::app()->db->tablePrefix.$nameOfTable;
		$baseDB = $nameOfTable;
		
		//Yii::log("reverse Deleted: $nameOfTable : $this->id");
						
		$result=$this->dbMove($baseDB, $targetDB, $uid);
		
		return($result);
	}

}