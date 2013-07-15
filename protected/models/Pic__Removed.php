<?php

/**
 * This is the model class for pictures, extends "{{attach}}".
 */
class Pic__Removed extends Pic
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDbConnection()
	{
		self::$db=Yii::app()->backupDB;
		if(self::$db instanceof CDbConnection)
			return self::$db;
		else
			throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
	}
	
}