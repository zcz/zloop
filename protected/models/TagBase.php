<?php

class TagBase extends SafeActiveRecord
{
	public $tagNumUser = 30;
	public $tagNumGeneral = 30;
	public $zloopValue = 12.0;
	public $tagValue = 10.0;
	public $viewWeight = 1.0;
	public $usedWeight = 1.0;
	
	public function giveMeACloud()
	{
		$cloud = array();
		//no zloop any more, 'zloop' only display can remain
		//$cloud['theZLOOPtitleIsHere'] = $this->newCloudNode('ZLOOP', $this->zloopValue, '');
		$this->collectFromUser($cloud);
		$this->collectGeneral($cloud);
		$result = array();
//print_r($cloud);
		foreach($cloud as $i => $c)
		{
			array_push($result, $c);
		}
		return($result);
	}
	
	public function collectFromUser(&$cloud)
	{
		$uid = Yii::app()->user->id;
		if ($uid == null || $uid == 0) return;
		
		$criteria = new CDbCriteria;
		$criteria->select = array('tagid', 'numview', 'numused');
		$criteria->condition = "userid=:userid";
		$criteria->params = array(':userid'=> $uid);
		$criteria->order = "($this->viewWeight*numview + $this->usedWeight*numused) DESC";
		$criteria->limit = $this->tagNumUser;
		
		$tags = TagUser::model()->findAll($criteria);
		$this->addTagsToCloud($tags, $cloud);
	}
	
	public function collectGeneral(&$cloud)
	{
		$criteria = new CDbCriteria;
		$criteria->select = array('id', 'numview', 'numused');
		$criteria->order = "($this->viewWeight*numview + $this->usedWeight*numused) DESC";
		$criteria->limit = $this->tagNumUser + $this->tagNumGeneral;
		
		$tags = Tag::model()->findAll($criteria);
		$this->addTagsToCloud($tags, $cloud);
	}
	
	public function addTagsToCloud($tags, &$cloud)
	{
		$num = count($cloud);
		$ttt = array();
		$total = 0.1;
		foreach ($tags as $i=>$tag)
		{

			if (isset($tag->id))
			{
				$idOfTag = $tag->id;
			} else
			{
				$idOfTag = $tag->tagid;
			}

			if ($num>=($this->tagNumUser + $this->tagNumGeneral + 1) || isset($cloud[$idOfTag]))
			{
				unset($tags[$i]);
			} else
			{
				$ttt[$idOfTag] = $this->viewWeight*$tag->numview + $this->usedWeight*$tag->numused;
				if ($ttt[$idOfTag]>$total) 
				{
					$total = $ttt[$idOfTag];
				}
				++$num;
			}
		}
		
		$num = count($ttt);
		if ($num == 0) return;
		$scale = ($this->tagValue)/($total);
		
		foreach( $ttt as $tagid=>$weight)
		{
			$tag = Tag::model()->findByPk($tagid);
			$weight *= $scale;
			$cloud[$tagid] = $this->newCloudNode($tag->tagName, $weight, $tag->tagName);
		}
	}
	
	public function newCloudNode($text, $weight, $url)
	{
		$result = array();
		$result['text'] = $text;
		$result['weight'] = $weight;
		if ($url == '')
		{
			$result['url'] = Yii::app()->createAbsoluteUrl("");
		} else
		{
			$result['url'] = Yii::app()->createAbsoluteUrl('/item/index', array(
								"keywords"=>$url));
		}
		return($result);
	}
	
	public function findAllItemByKey($key)
	{
		//criteria for title
		$ct_title=new CDbCriteria;
		$ct_title->select='id';
		$ct_title->condition="";
		$ct_title->condition.="title like :key";
	}
}
