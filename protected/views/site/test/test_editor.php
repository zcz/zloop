<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'key-search-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
$this->widget('application.extensions.cleditor.ECLEditor', array(
        'model'=>$model,
        'attribute'=>'keyString', //Model attribute name. Nome do atributo do modelo.
        'options'=>array(
            'width'=>'600',
            'height'=>250,
            'useCSS'=>true,
),
        'value'=>$model->keyString, //If you want pass a value for the widget. I think you will. Se você precisar passar um valor para o gadget. Eu acho irá.
)); ?>

<?php echo CHtml::submitButton('Search'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
