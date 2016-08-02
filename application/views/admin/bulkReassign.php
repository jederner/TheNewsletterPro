<?php
$this->load->helper('form');

$memberList = array();
foreach($teamList as $member) {
	$id			= $member["id"];
	$fname 		= $member["fname"];
	$lname		= $member["lname"];
	$arrCurrent = array(
					"id"	=> $id,
					"fname"	=> $fname,
					"lname"	=> $lname
				);
	array_push($memberList, $arrCurrent);
}

echo form_open('Admin/bulkReassign');
?>
<p>Select a source team member from whom you are transferring clients.</p>
<select name="sourceMember">
	<option value="">(select source)</option>
	<?php
	foreach($memberList as $member) {
		$id = $member["id"];
		$name = $member["lname"] . ", " . $member["fname"];
		echo "<option value='$id'>$name</option>\r\n";
	}
	?>
</select>
<p>Select a destination team member to whom you are transerring clients.</p>
<select name="destinationMember">
	<option value="">(select destination)</option>
	<?php
	foreach($memberList as $member) {
		$id = $member["id"];
		$name = $member["lname"] . ", " . $member["fname"];
		echo "<option value='$id'>$name</option>\r\n";
	}
	?>
</select>
<p>Once submitted, all clients will be assigned to the new team member.</p>
<?php
echo form_submit('Reassign', 'Reassign');
echo form_close();
?>