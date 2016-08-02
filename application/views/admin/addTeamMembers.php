<?php
$this->load->helper('form');

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
				'class'			=> 'clearfix'
			);

$formLastName = array(
				'name'			=> 'lname',
				'id'			=> 'lname',
				'placeholder'	=> 'last name',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix'
			);

$formPassword = array(
				'name'			=> 'password',
				'id'			=> 'password',
				'placeholder'	=> 'password',
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
				'class'			=> 'clearfix'
			);

$formEmail = array(
				'name'			=> 'email',
				'id'			=> 'email',
				'placeholder'	=> 'user.name',
				'maxlength'		=> '100',
				'size'			=> '25',
				'class'			=> 'clearfix'
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
	$teamOptions .= "<option value='" . $item['ListUID'] . "'>" . $item['ListLabel'] . "</option>\r\n";
}

function RandomString() {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randstring = '';
	for ($i = 0; $i < 10; $i++) {
		$randstring .= $characters[rand(0, strlen($characters))];
	}
	return $randstring;
}

$formPassword['value'] = RandomString();

echo anchor("/Admin/teamMembers","Cancel");

echo form_open('Admin/updateTeamMember', $formData);?>
<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Basic Information</a></li>
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
				<td><?php echo form_dropdown('status',$formStatusOptions); ?></td>
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
                            <td><?php echo $departmentsHTML; ?></td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td><?php echo $rolesHTML; ?></td>
                        </tr>
		</table>
	</div>
</div>
<input type="hidden" name="id" value="0" />
<?php
echo form_submit('update', 'Add');
echo form_close();