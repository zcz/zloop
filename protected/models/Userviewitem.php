<?php

/**
 * This is the model class for table "{{userviewitem}}".
 *
 * The followings are the available columns in table '{{userviewitem}}':
 * @property integer $id
 * @property integer $userid
 * @property integer $itemid
 * @property integer $view_time
 */
class Userviewitem extends SafeActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Userviewitem the static model class
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
		return '{{userviewitem}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, itemid', 'required'),
			array('userid, itemid, view_time', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userid, itemid, view_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	* @return array relational rules.
	*/
	public function relations()
	{
		return array(
			'user'=>array(self::BELONGS_TO, 'User', 'userid' ),
			'item'=>array(self::BELONGS_TO, 'Item', 'itemid' ),
		);
	}
	
	public function viewItem($item) {
		if (Yii::app()->user->isGuest) return;
		$userid = Yii::app()->user->id;
		$itemid = $item->id;
		$record = $this->findByAttributes(
		array("itemid"=>$itemid, "userid"=>$userid)
		);

		if ($record == null) {
			$record = new Userviewitem("create");
			$record->userid = $userid;
			$record->itemid = $itemid;
		}
	
		$record->view_time=time();
		$record->save(false);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userid' => 'Userid',
			'itemid' => 'Itemid',
			'view_time' => 'View Time',
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
		$criteria->compare('userid',$this->userid);
		$criteria->compare('itemid',$this->itemid);
		$criteria->compare('view_time',$this->view_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchItemsForUser() {
				
		$criteria=new CDbCriteria;
		
		$criteria->compare('userid', Yii::app()->user->id);
		$criteria->select='distinct itemid';
		$criteria->order="view_time DESC";
		
		$views=$this->findAll($criteria);
		$items = array();
		foreach($views as $i => $view) {
			array_push($items, $view->item);
		}
		
		return($items);
	}
}