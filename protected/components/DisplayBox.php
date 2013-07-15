<?php

/**
 * 
 * show dispaly box, which has a title, a moreLink and content
 * @author zcz
 *
 */

class DisplayBox extends CWidget
{

	public $title = "title_nothing";
	public $moreLink = null;
	public $content = "content_nothing";
	public $widget = null;
	public $withSpaceAround = true;
	public $withSpaceTopBottom = true;
        
    public function run()
    {
		$this->render("displayBox", 
			array(
				'title'=>$this->title, 
				'moreLink'=>$this->moreLink, 
				'content'=>$this->content,
				'widget'=>$this->widget,
				'space'=>$this->withSpaceAround,
				'spaceTopBottom'=>$this->withSpaceTopBottom,
			)
		);    	
    }
}