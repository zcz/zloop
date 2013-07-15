<?php
	$links = $model->getPathBreadCrumbs();
	$this->breadcrumbs=$links;
?>

<?php if(Yii::app()->user->hasFlash('actionError')): ?>
<div class="flash-error" style="margin-bottom: -4px;">
	<?php echo Yii::app()->user->getFlash('actionError'); ?>
</div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('actionDone')): ?>
<div class="flash-success" style="margin-bottom: -4px;">
	<?php echo Yii::app()->user->getFlash('actionDone'); ?>
</div>
<?php endif; ?>


<?php 
	
$this->renderPartial( "/item/itemHead" , array('item'=>$model));


$this->widget("DisplayBox", array(
	'title' => "Details:",
	'content' => $model->presentation . ' ',
	'withSpaceAround' => false,
));

$this->widget("DisplayBox", array(
	'title' => " Questions and answer: ",
	'content' => $this->renderPartial("/comment/commentForItem", array("item"=>$model), true),
	'withSpaceAround' => false,
));

?>
