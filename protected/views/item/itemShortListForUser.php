<div class="my-items-wrapper">
	<div class="my-items-header">
		<div>
			<?php echo CHtml::link("More", array("/user/moreItems", 'id'=>$model->id), array('class'=>"more-items"));?>
			<h4 class="header">My items</h4>
		</div>
	</div>

	<div class="my-items-body">
		<div class="my-items-body-in">
			<?php 
				$i = 0;
				foreach( $model->items as $item) {
					if (++$i > 2) break;
					$this->renderPartial("/item/showOneItem", array("model"=>$item));
				}
			
			?>
		</div>
	</div>
</div>