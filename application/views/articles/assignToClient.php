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

echo "<p style='font-weight:bold;'>" . $details[0]["article_name"] . "</p>";
echo anchor("/Articles/details/$article_id","Back to Article");
?>
<table id="assignArticles" class=''>
	<thead>
		<tr>
			<th>Company</th>
			<th>Edition</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($clients as $client) {
			$clientid = $client["client_id"];
			$companyname = $client["company_name"];
			$assignData = array(
				"class"	=>"assign",
				"data-article" => $clientid
			);
			echo "<tr>" .
					"<td>" . anchor("/Clients/details/$clientid",$companyname,"class='notBtn'") . "</td>
					<td>
						<select id='" . $clientid . "_article_edition_month'>
							" . $formArticleEditionMonthsOptions . "
						</select>
						<select id='" . $clientid . "_article_edition_year'>
							" . $formArticleEditionYearsOptions . "
						</select>
					</td>
					<td>" . anchor("/Articles/assignToClient/$clientid/$article_id","Assign", $assignData) . "</td>" .
				"</tr>";
		}
		?>
	</tbody>
</table>