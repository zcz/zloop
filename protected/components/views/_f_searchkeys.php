<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/searchBar.css" />
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'key-search-form',
	'enableAjaxValidation'=>true,
)); ?>
	
	
	<div id="searchwrapper">
	
		<?php 
			echo $form->textField($model, 'keyString', array('class'=>"searchbox", 'value'=>"")); 	
			$picUrl = Yii::app()->request->baseUrl . '/images/blank_button.png';
			echo CHtml::submitButton('Search', array('src'=>$picUrl, 'class'=>"searchbox_submit", 'value'=>"")); 
		?>
			
		<!--input type="text" class="searchbox" name="s" value="" /-->
		<!-- input type="submit" src="<?php //echo Yii::app()->request->baseUrl; ?>/images/blank_button.png" class="searchbox_submit" value="" /-->
	</div>
	
	
<?php $this->endWidget(); ?>
</div><!-- form -->
