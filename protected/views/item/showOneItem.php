<ul>
	<li>
		<?php 
			$s  = '<span class="item-image-wrapper">';
			$pics = $model->pictures;
			if ($pics != null && count($pics) != 0) {
				$s .= CHtml::image($pics[0]->getUrl(), "");
			}
			$s .= '</span>';
			$s .= '<span class="my-item-title">' . $model->title . '</span>';
			
			echo $model->getGeneralLink( $s , array("class"=>"my-item"));
		?>

		<div class="my-item-price">
			<?php echo $model->pricelow . '-' . $model->pricehigh . 'HKD'; ?>
		</div>
	</li>
</ul>