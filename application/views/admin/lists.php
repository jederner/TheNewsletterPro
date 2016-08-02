<?php echo anchor("/Admin/listsCategoryAdd","Add New List"); ?>
<div class='accordion'>
<?php
$curList = "";
$tick = 0;
foreach($lists as $list) {
	$type 	= $list['ListType'];
	$id 	= $list['ListUID'];
	$label 	= $list['ListLabel'];
	$active = $list['active'];
	$activeClass = "active";
	$activeText = "Active";
	if(!$active) {
		$activeText = "Inactive";
		$activeClass = "inactive";
	}
	$className = "";
	if($type!==$curList) {
		if($tick>0) {
			echo "</table></div>";
		}
		$tick++;
		echo "<h3>$type</h3>\r\n";
		echo "<div>";
		echo anchor("/Admin/listsOptionAdd/$type","Add Option");
		echo "<table cellpadding='3' cellspacing='0' style='margin-bottom:1em;'>";
		$curList = $type;
	}
	if($label==="default") {
		$className = "ghost";
	}
	echo "
		<tr class='$className'>
			<td>$label</td>
			<td>" . anchor("/Admin/listsOptionEdit/$id","Edit","class='notBtn'") . "</td>
			<td>" . anchor("/Admin/listsOptionToggle/$id/" . !$active,"Toggle","class='notBtn'") . "</td>
			<td><span class='$activeClass'>$activeText</span></td>
		</tr>";
}
echo "</table>";
?>
</div>
<br /><br />