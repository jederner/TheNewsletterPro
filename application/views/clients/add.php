<?php

$this->load->helper('form');

// Form
$formData = array(
				'class'	=> 'frmClient',
				'id' 	=> 'frmClient'
			);

// Company
$formCompany = array(
				'name'			=> 'company',
				'id'			=> 'company',
				'placeholder'	=> 'company name',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix'
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

$formStatusOptions = array(
				"active" => "active",
				"cancelled" => "cancelled",
				"on hold" => "on hold",
				"skip" => "skip"
			);

// Mailing Schedule
$found = false;
$formScheduleOptions = "<option value=''>(unassigned)</option>";
if(!empty($mailing_schedule)) {
	foreach($schedule as $entry) {
		if($mailing_schedule===$entry['ListLabel']) {
			$found = true;
		}
	}
}
if(!$found && !empty($mailing_schedule)) {
	$formScheduleOptions .= "<option value='$mailing_schedule' selected='selected'>$mailing_schedule</option>";
}
foreach($schedule as $entry) {
	$formScheduleOptions .= "<option value='" . $entry['ListLabel'] . "'>" . $entry['ListLabel'] . "</option>\r\n";
}
$formScheduleOptions .= "<option value='unique'>Unique</option>";
// End Mailing Schedule

$formTeamMemberOptions = "<option value=''>(unassigned)</option>";
foreach($teamMembers as $member) {
	$formTeamMemberOptions .= "<option value='" . $member['id'] . "'>" . $member['lname'] . ", " . $member['fname'] . "</option>\r\n";
}

$formTeamsListOptions = "<option value=''>(unassigned)</option>";
foreach($teamsList as $entry) {
	$formTeamsListOptions .= "<option value='" . $entry['ListUID'] . "'>" . $entry['ListLabel'] . "</option>\r\n";
}

$formWriterOptions = "<option value=''>(unassigned)</option>";
foreach($teamMembers as $member) {
	$formWriterOptions .= "<option value='" . $member['id'] . "'>" . $member['lname'] . ", " . $member['fname'] . "</option>\r\n";
}

$formDesignerOptions = "<option value=''>(unassigned)</option>";
foreach($teamMembers as $member) {
	$formDesignerOptions .= "<option value='" . $member['id'] . "'>" . $member['lname'] . ", " . $member['fname'] . "</option>\r\n";
}

$formPhone = array(
				'name'			=> 'phone',
				'id'			=> 'phone',
				'placeholder'	=> 'ex. 831-555-1234',
				'maxlength'		=> '50',
				'size'			=> '15',
				'class'			=> 'clearfix'
			);

$formEmail = array(
				'name'			=> 'email',
				'id'			=> 'email',
				'placeholder'	=> 'email@example.com',
				'maxlength'		=> '100',
				'size'			=> '25',
				'class'			=> 'clearfix'
			);

$formSubmit = array(
				'name'	=> 'submit',
				'id'	=> 'submit'
			);

$formDate_sold = array(
		'name'			=> 'date_sold',
		'id'			=> 'date_sold',
		'placeholder' 	=> '01/02/2015',
		'class'			=> 'clearfix dateMe'
	);
$formDate_onboarded = array(
		'name'			=> 'date_onboarded',
		'id'			=> 'date_onboarded',
		'placeholder' 	=> '01/02/2015',
		'class'			=> 'clearfix dateMe'
	);
$formSale_source = array(
		'name'			=> 'sale_source',
		'id'			=> 'sale_source',
		'placeholder' 	=> 'Sale Source',
		'class'			=> 'clearfix'
	);
$formCampaigns_billed = array(
		'name'			=> 'campaigns_billed',
		'id'			=> 'campaigns_billed',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix'
	);
$formPieces_mailed = array(
		'name'			=> 'pieces_mailed',
		'id'			=> 'pieces_mailed',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix'
	);
$formPrice_per_pieces = array(
		'name'			=> 'price_per_pieces',
		'id'			=> 'price_per_pieces',
		'placeholder' 	=> '10.50',
		'class'			=> 'clearfix'
	);
$formTeam = array(
		'name'			=> 'team',
		'id'			=> 'team',
		'placeholder' 	=> 'team',
		'class'			=> 'clearfix'
	);
$formWriter = array(
		'name'			=> 'writer',
		'id'			=> 'writer',
		'placeholder' 	=> 'writer',
		'class'			=> 'clearfix'
	);
$formDesigner = array(
		'name'			=> 'designer',
		'id'			=> 'designer',
		'placeholder' 	=> 'designer',
		'class'			=> 'clearfix'
	);
$formTotal_pages = array(
		'name'			=> 'total_pages',
		'id'			=> 'total_pages',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix'
	);
$formUnique_pages = array(
		'name'			=> 'unique_pages',
		'id'			=> 'unique_pages',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix'
	);
$formCustom_content = array(
		'name'			=> 'custom_content',
		'id'			=> 'custom_content',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix'
	);
$formFiller_content = array(
		'name'			=> 'filler_content',
		'id'			=> 'filler_content',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix'
	);
$formClient_submitted_content = array(
		'name'			=> 'client_submitted_content',
		'id'			=> 'client_submitted_content',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix'
	);
$formSide_campaigns = array(
		'name'			=> 'side_campaigns',
		'id'			=> 'side_campaigns',
		'placeholder' 	=> 'Side Campaigns',
		'class'			=> 'clearfix'
	);
$formMailing_Schedule = array(
		'name'			=> 'mailing_schedule_text',
		'id'			=> 'mailing_schedule_text',
		'placeholder' 	=> 'Mailing Schedule',
		'class'			=> 'clearfix',
		'style'			=> 'display:none;'
	);
$formReturn_date = array(
		'name'			=> 'return_date',
		'id'			=> 'return_date',
		'placeholder' 	=> '01/02/2015',
		'class'			=> 'clearfix dateMe'
	);
$formLayout_Guide = array(
		'name'			=> 'layout_guide',
		'id'			=> 'layout_guide',
		'placeholder'	=> 'Layout guide',
		'class'			=> 'clearfix',
		'rows'			=> '10',
		'cols'			=> '50'
	);
$formNotes = array(
		'name'			=> 'notes',
		'id'			=> 'notes',
		'placeholder'	=> 'Notes',
		'class'			=> 'clearfix',
		'rows'			=> '20',
		'cols'			=> '70'
	);

$formClientDemographicOptions = "<div>";
foreach($demographics as $item) {
	$label = $item["ListLabel"];
	$value = $item["ListUID"];
	$formClientDemographicOptions .= "<div class='checkbox_wrapper'><input type='checkbox' name='demographics[]' value='$value' />&nbsp;$label</div>";
}
$formClientDemographicOptions .= "</div>";

echo anchor("/Clients/view","Cancel");

echo form_open('clients/add', $formData);?>
<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Basic Information</a></li>
		<li><a href="#tabs-2">Mailing Information</a></li>
		<li><a href="#tabs-4">Sales</a></li>
		<li><a href="#tabs-5">Team</a></li>
		<li><a href="#tabs-6">Content</a></li>
		<li><a href="#tabs-7">Notes</a></li>
	</ul>
	<div id="tabs-1">
		<table class="tblClientDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td>Company Name</td>
				<td>
					<?php echo form_input($formCompany); ?>
					<div id='company_already_added' style='display:none;'>A client with this name has already been added. Please add another.</div>
				</td>
			</tr>
			<tr>
				<td>First Name</td>
				<td><?php echo form_input($formFirstName); ?></td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td><?php echo form_input($formLastName); ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><?php echo form_dropdown('status',$formStatusOptions); ?></td>
			</tr>
			<tr id="returnDateRow">
				<td>Return Date</td>
				<td><?php echo form_input($formReturn_date); ?></td>
			</tr>
			<tr>
				<td>Phone</td>
				<td><?php echo form_input($formPhone); ?></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><?php echo form_input($formEmail); ?></td>
			</tr>
		</table>
	</div>
	<div id="tabs-2">
		<table class="tblClientDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td>Mail Date</td>
				<td>
					<select name="mail_date">
						<?php
						$arrDates = array("","5th","15th","20th","25th","30th");
						foreach($arrDates as $date) {
							echo "<option value='$date'>$date</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Mailing Schedule</td>
				<td>
					<?php echo form_input($formMailing_Schedule); ?>
					<select name='mailing_schedule_select' id='mailing_schedule_select'>
						<?php echo $formScheduleOptions; ?>
					</select>
					<button style="display:none;" id="flipToSelect">Use List</button>
				</td>
			</tr>
			<tr>
				<td>Package Type</td>
				<td><input name="package_type" type='text' /></td>
			</tr>
			<tr>
				<td>List Size</td>
				<td><input name="list_size" type='text' /></td>
			</tr>
			<tr>
				<td>Versions</td>
				<td><input name="versions" type='text' /></td>
			</tr>
			<tr>
				<td>Demographics</td>
				<td><?php echo $formClientDemographicOptions; ?></td>
			</tr>
			<tr>
				<td>Side Campaigns</td>
				<td><?php echo form_input($formSide_campaigns); ?></td>
			</tr>
		</table>
	</div>
	<div id="tabs-4">
		<table class="tblClientDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td>Date Sold</td>
				<td><?php echo form_input($formDate_sold); ?></td>
			</tr>
			<tr>
				<td>Date Onboarded</td>
				<td><?php echo form_input($formDate_onboarded); ?></td>
			</tr>
			<tr>
				<td>Sale Source</td>
				<td><?php echo form_input($formSale_source); ?></td>
			</tr>
			<tr>
				<td>Campaigns Billed</td>
				<td><?php echo form_input($formCampaigns_billed); ?></td>
			</tr>
			<tr>
				<td>Pieces Mailed</td>
				<td><?php echo form_input($formPieces_mailed); ?></td>
			</tr>
			<tr>
				<td>Price Per Pieces</td>
				<td><?php echo form_input($formPrice_per_pieces); ?></td>
			</tr>
		</table>
	</div>
	<div id="tabs-5">
		<table class="tblClientDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td>Project Manager</td>
				<td>
					<select name='owned_by' id='owned_by'>
						<?php echo $formTeamMemberOptions; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Team</td>
				<td>
					<select name='team' id='team'>
						<?php echo $formTeamsListOptions; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Writer</td>
				<td>
					<select name='writer' id='writer'>
						<?php echo $formWriterOptions; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Designer</td>
				<td>
					<select name='designer' id='designer'>
						<?php echo $formDesignerOptions; ?>
					</select>
				</td>
			</tr>
		</table>
	</div>
	<div id="tabs-6">
		<table class="tblClientDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td>Total Pages</td>
				<td><?php echo form_input($formTotal_pages); ?></td>
			</tr>
			<tr>
				<td>Unique Pages</td>
				<td><?php echo form_input($formUnique_pages); ?></td>
			</tr>
			<tr>
				<td>Custom Content</td>
				<td><?php echo form_input($formCustom_content); ?></td>
			</tr>
			<tr>
				<td>Filler Content</td>
				<td><?php echo form_input($formFiller_content); ?></td>
			</tr>
			<tr>
				<td>Client Submitted Content</td>
				<td><?php echo form_input($formClient_submitted_content); ?></td>
			</tr>
			<tr>
				<td>Layout Guide</td>
				<td><?php echo form_textarea($formLayout_Guide); ?></td>
			</tr>
		</table>
	</div>
	<div id="tabs-7">
		<table class="tblClientDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td>Notes</td>
				<td><?php echo form_textarea($formNotes); ?></td>
			</tr>
		</table>
	</div>
</div>
<?php
if(($_SESSION["UserRole"]==="team member") || ($_SESSION["UserRole"]==="admin")) {
	echo form_submit('add', 'Add');
}
echo form_close();
?>