<?php

/**
 * This is the model class for table "{{appointment}}".
 *
 * The followings are the available columns in table '{{appointment}}':
 * @property integer $id
 * @property integer $parentid
 * @property integer $itemid
 * @property integer $fromuserid
 * @property integer $touserid
 * @property integer $meetingtime
 * @property string $meetingaddress
 * @property string $notes
 * @property string $reply
 * @property integer $confirmed
 * @property integer $create_time
 */
class Appointment extends SafeActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Appointment the static model class
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
		return '{{appointment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fromuserid, touserid, meetingtime, meetingaddress, create_time', 'required'),
			array('parentid, itemid, fromuserid, touserid, meetingtime, confirmed, create_time', 'numerical', 'integerOnly'=>true),
			array('notes, reply', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parentid, itemid, fromuserid, touserid, meetingtime, meetingaddress, notes, reply, confirmed, create_time', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parentid' => 'Parentid',
			'itemid' => 'Itemid',
			'fromuserid' => 'Fromuserid',
			'touserid' => 'Touserid',
			'meetingtime' => 'Meetingtime',
			'meetingaddress' => 'Meetingaddress',
			'notes' => 'Notes',
			'reply' => 'Reply',
			'confirmed' => 'Confirmed',
			'create_time' => 'Create Time',
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
		$criteria->compare('parentid',$this->parentid);
		$criteria->compare('itemid',$this->itemid);
		$criteria->compare('fromuserid',$this->fromuserid);
		$criteria->compare('touserid',$this->touserid);
		$criteria->compare('meetingtime',$this->meetingtime);
		$criteria->compare('meetingaddress',$this->meetingaddress,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('reply',$this->reply,true);
		$criteria->compare('confirmed',$this->confirmed);
		$criteria->compare('create_time',$this->create_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}