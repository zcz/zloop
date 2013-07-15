<?php

/**
 * This is the model class for table "{{attach}}".
 *
 * The followings are the available columns in table '{{attach}}':
 * @extended by Pic, but has no table, share with attach
 */
class Attach extends SafeActiveRecord
{
	//used for the form input
	public $isDelete = false;
	
	//used for getting data from input form
	public $attachOrder;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Attach the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{attach}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itemid, data, icon', 'required'),
			array('itemid, last_modified, deleted', 'numerical', 'integerOnly'=>true),
			array('title, story', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, itemid, last_modified, data, icon, title, story, deleted', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'item'=>array(self::BELONGS_TO, 'Item', 'itemid' ),
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('itemid',$this->itemid);
		$criteria->compare('last_modified',$this->last_modified);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('story',$this->story,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}