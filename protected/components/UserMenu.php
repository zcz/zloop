<?php

Yii::import('zii.widgets.CPortlet');
 

/**
 * 
 * The user menu widgets, show user controls
 * @author zcz
 *
 */
class UserMenu extends CPortlet
{
    public function init()
    {
        $this->title=CHtml::encode(Yii::app()->user->name);
        parent::init();
    }
 
    protected function renderContent()
    {
        $this->render('userMenu');
    }
}


