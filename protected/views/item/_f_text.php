<div class="row">
<?php

$this->widget('application.extensions.cleditor.ECLEditor', array(
        'model'=>$model,
        'attribute'=>'presentation', //Model attribute name. Nome do atributo do modelo.
        'options'=>array(
            'width'=>'635',
            'height'=>250,
            'useCSS'=>true,
),
        'value'=>$model->presentation, //If you want pass a value for the widget. I think you will. Se você precisar passar um valor para o gadget. Eu acho irá.
)); ?>
</div>

