<?php
$this->load->helper('form');

foreach($details as $detail) {
	$userid 	= $detail["id"];
	$fname 		= $detail["fname"];
	$lname 		= $detail["lname"];
	$phone 		= $detail["phone"];
	$email 		= $detail["email"];
	$status 	= $detail["status"];
	$team 		= $detail["team"];
	$teamID		= $detail["teamID"];
}

// Form
$formData = array(
				'class'	=> 'frmClient',
				'id' 	=> 'frmClient'
			);

// First Name
$formFirstName = array(
				'name'			=> 'fname',
				'id'			=> 'fname',
				'placeholder'	=> 'first name',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix',
				'value'			=> $fname
			);

$formLastName = array(
				'name'			=> 'lname',
				'id'			=> 'lname',
				'placeholder'	=> 'last name',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix',
				'value'			=> $lname
			);

$formPassword = array(
				'name'			=> 'password',
				'id'			=> 'password',
				'placeholder'	=> 'enter to reset password',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix'
			);

$formPhone = array(
				'name'			=> 'phone',
				'id'			=> 'phone',
				'placeholder'	=> 'ex. 831-555-1234',
				'maxlength'		=> '12',
				'size'			=> '15',
				'class'			=> 'clearfix',
				'value'			=> $phone
			);

$formEmail = array(
				'name'			=> 'email',
				'id'			=> 'email',
				'placeholder'	=> 'email@example.com',
				'maxlength'		=> '100',
				'size'			=> '25',
				'class'			=> 'clearfix',
				'value'			=> $email
			);

$formStatusOptions = array(
				"active" => "active",
				"cancelled" => "cancelled",
				"on hold" => "on hold",
				"skip" => "skip"
			);

$formSubmit = array(
				'name'	=> 'submit',
				'id'	=> 'submit',
				'value'	=> 'Login'
			);

$teamOptions = "<option value=''>(unassigned)</option>";
foreach($teamList as $item) {
	$teamOptions .= "<option ";
	if($item['ListUID']===$teamID) {
		$teamOptions .= "selected='selected' ";
	}
	$teamOptions .= "value='" . $item['ListUID'] . "'>" . $item['ListLabel'] . "</option>\r\n";
}

?>
<?php echo anchor("Admin/teamMembers","Team Members"); ?>
<?php echo form_open('Admin/updateTeamMember', $formData);?>
<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Basic Information</a></li>
		<li><a href="#tabs-2">Admin</a></li>
	</ul>
	<div id="tabs-1">
		<table class="tblClientDetails" cellpadding="3" cellspacing="0">		
			<tr>
				<td>First Name</td>
				<td><?php echo form_input($formFirstName); ?></td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td><?php echo form_input($formLastName); ?></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><?php echo form_password($formPassword); ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><?php echo form_dropdown('status',$formStatusOptions,$status); ?></td>
			</tr>
			<tr>
				<td>Phone</td>
				<td><?php echo form_input($formPhone); ?></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><?php echo form_input($formEmail); ?></td>
			</tr>
			<tr>
				<td>Team</td>
				<td>
					<select name='team' id='team'>
						<?php echo $teamOptions; ?>
					</select>
				</td>
			</tr>
                        <tr>
				<td>Department</td>
				<td>
					<?php echo $departmentsHTML; ?>
				</td>
			</tr>
                        <tr>
				<td>Role</td>
				<td>
					<?php echo $rolesHTML; ?>
				</td>
			</tr>
		</table>
	</div>
	<div id="tabs-2">
		<?php echo anchor("Admin/deleteTeamMember/$userid", "Delete", "class='hrefConfirm'"); ?>
	</div>
</div>
<input type="hidden" name="id" value="<?php echo $userid; ?>" />
<?php
echo form_submit('update', 'Update');
echo form_close();
?>
<div style="display:none;" id="hrefConfirm" title="Are you sure?">
	<p>This action is permanent. Are you sure you wish to continue?</p>
</div>