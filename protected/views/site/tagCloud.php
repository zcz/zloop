<?php 

//print_r(Tag::model()->giveMeACloud());

$this->widget('ext.jcloud.JCloud', array(
    'id'=>'my_favorite_latin_words',
    'htmlOptions'=>array(
                        'style'=>'width: 100%; 
                        height: 380px; 
                        border: 0px solid #bcc;'),
    'wordList'=>Tag::model()->giveMeACloud(),
    )
); 
?><!-- cloud -->