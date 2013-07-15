<?php

/**
 * This is the model class for table "{{email}}".
 *
 * The followings are the available columns in table '{{email}}':
 * @property integer $id
 * @property string $fromemail
 * @property string $toemail
 * @property string $title
 * @property string $body
 * @property integer $create_time
 */
class Email extends SafeActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Email the static model class
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
		return '{{email}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('toemail, title, body', 'required'),
			array('create_time', 'numerical', 'integerOnly'=>true),
			array('fromemail, toemail', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fromemail, toemail, title, body, create_time', 'safe', 'on'=>'search'),
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
			'fromemail' => 'Fromemail',
			'toemail' => 'Toemail',
			'title' => 'Title',
			'body' => 'Body',
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
		$criteria->compare('fromemail',$this->fromemail,true);
		$criteria->compare('toemail',$this->toemail,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('create_time',$this->create_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord) {
				$this->create_time=time();
			}
			return true;
		}
		else
		return false;
	}
}