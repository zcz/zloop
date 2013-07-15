<?php

/**
 * This is the model class for table "user"
 * 
 * This is used for storing the users 
 * waiting for email authentication
 */
class User_D extends UserBase
{
	public $deleted = true;
		
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 * not {{user}} because use the table storing the deleted items
	 */
	public function tableName()
	{
		return 'user';
	}

	public function beforeSave()
	{
		return false;
	}

}
