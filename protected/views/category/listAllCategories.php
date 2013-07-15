<!--create category table page-->
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/categoryTable.css" type="text/css" />
<div id="all-categories">
	<div class="all-categories">
		<h2 class="category-title">All Categories &nbsp;&nbsp;(Choosing an appropriate category is very important to your selling success)</h2>
		<div class="category-table-wrapper">
			<div class="category-table">
			
<?php

$rootCategory = Category::model()->findByPk(0);

echo printCategoryTable($rootCategory);

function printCategoryTable($category)
{
	$a = array();
	
	$s = "";
	$s .= '<table cellspacing="0" cellpadding="0">';
	
	foreach ($category->subCategories as $t=>$cate)
	{
		array_push($a, $cate);
		if (count($a)==4)
		{	
			$s .= printOneRow($a);
			$a = array();
		}
	}
	
	if (count($a)!=0)
	{
		$s .= printOneRow($a);
		$a = array();
	}
	
	$s .= '</table>';
	return($s);
}

function printOneRow($list)
{
	$s = "";
	$s .= '<tr>';
	foreach ($list as $i => $ctg)
	{
		$s .= '<td width="25%" class="cell">';
		$s .= '<ul class="category-list">';
		$s .= '<li class="category-list-title">'.getOneCategoryLink($ctg).'</li>';
		foreach ($ctg->subCategories as $ii => $sub)
		{
			$s .= '<li>'.getOneCategoryLink($sub).'</li>';
		}
		$s .= '</ul>';
		$s .= '</td>';
	}
	$s .= '</tr>';
	$s .= '<tr>';
	$s .= '<td colspan="4" class="splitter">';
	$s .= '<img src="" height="1" alt="">';
	$s .= '</td>';
	$s .= '</tr>';
		
	return($s);
}

function getOneCategoryLink($category)
{
	$s = Yii::app()->createUrl("category/listAllCategories", 
		array("selectedCategory"=>$category->id));
	$s = "<a href=".$s.">".$category->title."</a>";
	return ($s);	
}

?>

				</div>
			</div>
		<div class="category-footer"><div/>
	</div>
</div>
