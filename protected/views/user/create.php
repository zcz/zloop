<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/createAccount.css" type="text/css" media="screen" /> 
<div class="create-account">
<h3>Create an Account</h3>
<br/>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
<div style="float:left; margin-top:2px;">
	<img src="/images/decoration/hahatree.png" width="318px" />
</div>