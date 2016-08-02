<?php
$dateArray = explode("-", $assignDate);
$arrArticleEditionMonthsOptions = array(
		array("01","January"),
		array("02","February"),
		array("03","March"),
		array("04","April"),
		array("05","May"),
		array("06","June"),
		array("07","July"),
		array("08","August"),
		array("09","September"),
		array("10","October"),
		array("11","November"),
		array("12","December")
	);
$formArticleEditionMonthsOptions = "";
foreach($arrArticleEditionMonthsOptions as $item) {
	$formArticleEditionMonthsOptions .= "<option value='" . $item[0] . "'";
	if($item[0]===$dateArray[1]) {
		$formArticleEditionMonthsOptions .= " selected='selected'";
	}
	$formArticleEditionMonthsOptions .= ">" . $item[1] . "</option>\r\n";
}

$arrArticleEditionYearsOptions = array();
for($i=2010;$i<=date("Y");$i++) {
	array_push($arrArticleEditionYearsOptions, $i);
}
$formArticleEditionYearsOptions = "";
foreach($arrArticleEditionYearsOptions as $item) {
	$formArticleEditionYearsOptions .= "<option value='$item'";
	if($item==$dateArray[0]) {
		$formArticleEditionYearsOptions .= " selected='selected'";
	}
	$formArticleEditionYearsOptions .= ">$item</option>";
}

sort($categoriesAvailable);
$newDemo = array();
foreach($demographicsAvailable as $oldDemo) {
	$curArr = explode(",", $oldDemo);
	foreach($curArr as $item) {
		$item = trim($item);
		array_push($newDemo, $item);
	}
}
$demographicsAvailable = array_unique($newDemo);
sort($demographicsAvailable);

echo anchor("Clients/details/$clientId", "Back to $company");
?>
<h1 style="margin-top:2em">Filters</h1>
<div class="accordion">
	<h3>Categories</h3>
	<div id="filters_categories">
		<?php
		foreach($categoriesAvailable as $catFilter) {
			echo "<div class='checkFilter'><input class='newFilter' type='checkbox' name='category' value='$catFilter'>&nbsp;$catFilter</div>";
		}
		?>
	</div>
	<h3>Demographics</h3>
	<div id="filters_demographics">
		<?php
		foreach($demographicsAvailable as $demoFilter) {
			echo "<div class='checkFilter'><input class='newFilter' type='checkbox' name='demographic' value='$demoFilter'>&nbsp;$demoFilter</div>";
		}
		?>
	</div>
</div>
&nbsp;<br />
<table id="assignArticles" class="dataTable_custom" cellpadding="3" cellspacing="0">
	<thead>
		<tr>
			<th>Article</th>
			<th>Category</th>
			<th>Demographic</th>
			<th>Edition</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($articles as $article) {
			$article_id =			$article["id"];
			$article_name =			$article["article_name"];
			$article_path =			$article["article_path"];
			$article_category =		$article["category"];
			$article_demographic =	$article["article_demographic"];
			$article_keywords =		$article["article_keywords"];
			$article_description = 	$article["article_description"];

			$assignData = array(
				"class"	=>"assign",
				"data-article" => $article_id
			);
			$anchorData = array(
				"class" => "notBtn",
				"title" => $article_description
			);
			echo "
				<tr data-id='$article_id'>
					<td class='clickable'>
						" . anchor("Articles/details/$article_id",$article_name,$anchorData) . "
					</td>
					<td class='clickable'>$article_category</td>
					<td class='clickable'>$article_demographic</td>
					<td>
						<select id='" . $article_id . "_article_edition_month'>
							" . $formArticleEditionMonthsOptions . "
						</select>
						<select id='" . $article_id . "_article_edition_year'>
							" . $formArticleEditionYearsOptions . "
						</select>
					</td>
					<td>" . anchor("Clients/assignArticles/$clientId/$article_id", 'Assign', $assignData) . "
				</tr>";

		}
		?>
	</tbody>
</table>