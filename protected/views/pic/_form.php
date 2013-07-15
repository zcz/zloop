<?php 

	echo '<tr>';
	if (count($model->pictures)!=0) 
	{
		echo '<td valign=top>' . $form->label(Pic::model(),"isDelete") . '</td>'; 
	}
	
	echo '<td colspan="2"><table border=0>';
	foreach($model->pictures as $i=>$pic)
	{
		echo '<tr>';
		echo '<td width = 40%>';
		echo $form->checkBox($pic,"[$i]isDelete", array('class'=>"bigcheck"));
		echo CHtml::image($pic->getUrl(), "", array('height'=>'60'));
		echo '</td>';
		echo '<td>';
		displayDescription($form, $pic, $i);
		echo '</td>';
		echo '</tr>';
		
		echo '<tr>';
		echo $form->error($pic,"[$i]isDelete");
		echo '</tr>';
		
	}
	echo '</table></td></tr>';

	echo '<tr>';
	if (count($model->pics)!=0) 
	{
		echo '<td valign=top>' . $form->labelEx(Pic::model(),"data") . '</td>'; 
	}

	
	echo '<td colspan="2"><table border=0>';
	foreach($model->pics as $i=>$pic)
	{
		echo '<tr>';
		echo '<td width = 40%>';
		echo $form->fileField($pic,"[$i]data");
		echo '</td>';
		echo '<td>';
		displayDescription($form, $pic, $i);
		echo '</td>';
		echo '</tr>';
		
		echo '<tr>';
		echo $form->error($pic,"[$i]data");
		echo '</tr>';
		
		
	}
	echo '</table></td></tr>';
	
	
function displayDescription($form, $pic, $i)
{
	$story_length = 26;
	echo '&nbsp'.'&nbsp'.'&nbsp'.$form->labelEx($pic,'story') . '&nbsp';
	echo $form->textField($pic,"[$i]story", array('size'=>"$story_length"));
	echo '<br/>';
}
	
?>
