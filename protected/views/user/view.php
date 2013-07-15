<?php
/* not show breadcrumbs for users
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->username,
);
*/
?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/myZloop.css" />

<div class="profile-wrapper">

	<div class="profile-right-upper">
		<div>
			<div class="edit-profile">
				<?php 
					if ($model->id == Yii::app()->user->id) {
						echo CHtml::link("Edit Profile", array("update", 'id'=>$model->id)); 
					}
				?>
			</div>
			<div class="profile-id">
				<span><?php echo $model->username; ?></span>
			</div>
		</div>
	</div>

	<div class="profile-left">
		<div class="profile-pic">	
			<?php echo CHtml::image(Pic::model()->getUserLargePic($model), ""); ?>
		</div>

		<?php $this->renderPartial('/user/contactDetail', array('model'=>$model));?>	
		
		<?php //$this->renderPartial('/item/itemShortListForUser', array('model'=>$model));?>
		
	</div>	
	
	<div class="profile-right-lower">
		<div>
			
			<?php 
				if ($model->id == Yii::app()->user->id) {
					$this->renderPartial("MyInterestList", array('model'=>$model) );
					$this->renderPartial("MyViewList", array('model'=>$model) );
				} else {
					$this->renderPartial("MyItemList", array('model'=>$model) );
				}
			?>
		
			<div class="profile-content">
				
				<?php 
					$this->renderPartial('/message/newMessage_Beauty', array("touserid"=>$model->id)); 
				?>
				
				<?php 
					//render the data part, all the comments
					$this->renderPartial('/message/listMessage_Beauty',array('dataProvider'=>$dataProvider));
				?>		

			</div>
		</div>
	</div>	
</div>
